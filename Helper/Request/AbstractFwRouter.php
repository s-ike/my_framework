<?php
namespace FW\Helper\Request;

use Exception;
use FW\Controllers;
use FW\Helper\SampleHelper;

require_once dirname(__FILE__).'/../../fw_config/config.php';

abstract class AbstractFwRouter
{
    /**
     * /Config/Router/内で定義した内容
     *
     * @var array
     */
    private $conf;

    /**
     * defineで設定しているトップディレクトリ
     *
     * @var string
     */
    private $urlPrefix = FW_TOP_URL;

    /**
     * コンストラクタ
     *
     * @param array $conf
     */
    public function __construct($conf)
    {
        $this->conf = $conf;
    }

    /**
     * ルーティング定義の追加
     * NOTE: テストしていない関数
     * TODO: テスト
     *
     * @param string $path          '/', 'author/:id', etc
     * @param string $class_method  'IndexController@index', etc
     *
     * @return bool
     */
    public function add($path, $class_method)
    {
        if (strpos($path, '/') !== false
        && strpos($class_method, 'Controller') !== false) {
            $this->cong[$path] = $class_method;
            return true;
        }
        return false;
    }

    /**
     * abstract function
     * ルーティング定義からリクエストURIに一致するものを探して返す
     *
     * @param string $request_uri $_SERVER['REQUEST_URI']
     * @param int    $code        HTTP status code
     *
     * @return void
     */
    abstract public function search($request_uri, $code);

    /**
     * リクエストURIを/で分割し配列にする
     *
     * @param string $request_uri
     *
     * @return array|false
     */
    protected function perthUri($request_uri)
    {
        // 末尾の/をとる
        while (preg_match('!.*/$!', $request_uri)) {
            $request_uri = substr($request_uri, 0, -1);
        }
        // $request_uri -> $urls
        // $urls = Array
        // (
        //     [scheme] => https
        //     [host] => www.example.com
        //     [path] => /blog/123
        // )
        $urls = parse_url($request_uri);
        $path = $urls['path'];

        // [path] => /blog/123 のようにprefixが最初にあるかどうか
        if ($this->urlPrefix !== '' && strpos($path, $this->urlPrefix) !== 0) {
            // TODO: /blogのリクエストではない場合
            return false;
        }
        // prefix以降を取得
        $path = substr($urls['path'], strpos($path, $this->urlPrefix.'/')+strlen($this->urlPrefix.'/'));

        // example.com/blog/ :
        // $dir = Array()

        // example.com/blog/123 :
        // $dir = Array
        // (
        //     [0] => 123
        // )

        // example.com/blog/author/xxx/list :
        // $dir = Array
        // (
        //     [0] => author
        //     [1] => xxx
        //     [2] => list
        // )
        $dirs = array_filter(explode('/', $path));
        return $dirs;
    }

    /**
     * confからリクエストURIにマッチする値（class@method）を取得
     *
     * @param array $dirs リクエストURIを/で区切り配列にしたもの
     *
     * @return array|false array(定義されているパス, 定義されているclass@method)
     */
    protected function searchInConf($dirs)
    {
        if (count($this->conf) === 0) {
            return false;
        }

        $count = count($dirs);

        // TOP NOTE:"blog/数字"のURIの場合、TOPページだと決めつける
        if ($count === 0 || (isset($dirs[0]) && ctype_digit($dirs[0])) || $dirs === false) {
            return $this->searchTopPage();
        }

        // /blog/string/... blogの次の/string/はパラメータではないと決めつけている
        $pattern = '!^/'.$dirs[0].'([^/]*/){'.--$count.'}[^/]*$!';
        $tmp_matches = preg_grep($pattern, array_keys($this->conf));
        $matches = array();
        foreach ($tmp_matches as $path) {
            if (isset($this->conf[$path])) {
                $matches[$path] = $this->conf[$path];
            }
        }
        unset($tmp_matches);
        // $request_uri = 'https://www.example.com/blog/author/hoge/list/hoge';
        // $matches = Array
        // (
        //     [/author/:name/list/:page] => AUthorController@list
        //     [/author/:name/entry/:id] => AUthorController@entry
        // )

        $matche_list = array();

        // 古いルーティングルールの可能性
        if (count($matches) === 0) {
            $truecount = $count;    // $countは--$countを前にしているので１つずれている
            if (++$truecount === 2 && (isset($dirs[1]) && ctype_digit($dirs[1]))) {
                // /:abc/:123 を想定
                $tmp_matches = preg_grep('!^/:([^/]*/:[^/]*$)!', array_keys($this->conf));
                if (count($tmp_matches) === 1) {
                    $path = max($tmp_matches);
                    $class_method = $this->conf[$path];
                    return array($path, $class_method);
                }
            }
            unset($tmp_matches);
        }

        $i = 0;
        foreach ($dirs as $param) {
            if ($i === 0) {
                $pattern = '!^/'.$param.'/.*$!';
            } elseif ($i === $count) {
                $pattern = '!^/.*/'.$param.'$!';
            } else {
                $pattern = '!^/.*/'.$param.'/.*$!';
            }
            $tmp_matches = preg_grep($pattern, array_keys($matches));
            if (count($tmp_matches)) {
                $matche_list[] = $tmp_matches;
            }
            $i++;
        }
        unset($matches);
        // $matche_list = Array
        // (
        //     [0] => Array
        //         (
        //             [0] => /author/:name/list/:page
        //             [1] => /author/:name/entry/:id
        //         )
        //     [1] => Array
        //         (
        //             [0] => /author/:name/list/:page
        //         )
        // )

        $matche_count = count($matche_list);
        if (! $matche_count) {
            return false;
        } elseif ($matche_count === 1) {
            $matches = $matche_list[0];
            if (count($matches) === 1) {
                // 1つだけマッチした場合
                $path = end($matches);
                $class_method = $this->conf[$path];
                return array($path, $class_method);
            } else {
                // 1つの検索ルールで複数マッチした場合
                $results = array();
                // $matches = Array
                // (
                //     [0] => /author/:name/list/:page
                //     [1] => /author/:name/entry/:id
                // )
                foreach ($matches as $key => $eachpath) {
                    $splits = array_values(array_filter(explode('/', $eachpath)));
                    // $splits = Array
                    // (
                    //     [0] => author
                    //     [1] => :name
                    //     [2] => list
                    //     [3] => :page
                    // )
                    $resulit[$key] = count(array_diff_assoc($dirs, $splits));
                }
                // $resulit = Array
                // (
                //     [0] => 3
                //     [1] => 3
                // )
                if (count($resulit)) {
                    if ($resulit === array_unique($resulit)) {
                        // 重複なしの場合、最小値のキーを取得
                        $min_key = array_keys($resulit, min($resulit));
                        $min_key = (min($min_key));
                        $path = $matches[$min_key];
                        $class_method = $this->conf[$path];
                        return array($path, $class_method);
                    }
                }
                return false;
            }
        } else {
            // 複数マッチした場合、最頻出を取得する
            $results = array();
            foreach ($matche_list as $matches) {
                foreach ($matches as $path) {
                    if (isset($results[$path])) {
                        $value = $results[$path];
                        $results[$path] = ++$value;
                    } else {
                        $results[$path] = 1;
                    }
                }
            }
            $maxs = array_keys($results, max($results));
            if (count($maxs) === 1) {
                $path = $maxs[0];
                $class_method = $this->conf[$path];
                return array($path, $class_method);
            }
            return false;
        }
    }

    /**
     * $this->confからtopページに該当する設定を探す
     *
     * @return array|false array(定義されているパス, 定義されているclass@method)
     */
    private function searchTopPage()
    {
        $tmp_matches = preg_grep('!^/(:([^/]*$)|$)!', array_keys($this->conf));

        $path_class_method = array();
        foreach ($tmp_matches as $path) {
            if (isset($this->conf[$path])) {
                $path_class_method[$path] = $this->conf[$path];
            }
        }

        if (count($path_class_method)) {
            $path = array_keys($path_class_method);
            $path = end($path);
            $class_method = end($path_class_method);
            return array($path, $class_method);
        }
        return false;
    }

    /**
     * Undocumented function
     *
     * @param array $conf このリクエストに対応した$this->confから抜き出したキーと値
     * @param array $dirs リクエストURIを/で区切り配列にしたもの
     *
     * @return array|false
     */
    protected function extractParams($conf, $dirs)
    {
        $path = isset($conf[0]) ? $conf[0] : null;
        $class_method = isset($conf[1]) ? $conf[1] : null;
        if (! $path || ! $class_method) {
            return false;
        }

        $path_splits = array_values(array_filter(explode('/', $path)));
        if (count($path_splits) !== count($dirs)) {
            return false;
        }

        $params = array();
        foreach ($path_splits as $key => $value) {
            if (preg_match('/^:.*/', $value)) {
                $params[$key] = $dirs[$key];
            }
        }

        return $params;
    }

    /**
     * 決められたコントローラー名と関数名の書式から、その関数を呼び出す
     *
     * @param string    $class_method   'Controller@method'
     * @param integer   $code           HTTP status code
     * @param array     $params         パラメータ
     *
     * @return void|false
     */
    protected function view($class_method, $code = 200, $params = array())
    {
        $array = array_filter(explode('@', $class_method));
        $class = "FW\Controllers\\".$array[0];
        $method = isset($array[1]) ? $array[1] : 'index';
        $class_obj = new $class;
        // $methodが存在しない可能性がある
        try {
            $class_obj->$method($params, $code);
        } catch (\Exception $e) {
            return false;
        }
    }
}
