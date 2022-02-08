<?php
namespace FW\Helper\Request;

class FwRouter
{
    /**
     * AbstractFwRouterインスタンスを格納する配列
     *
     * @var array(AbstractFwRouter)
     */
    private $methods;

    /**
     * FwRouterインスタンス
     *
     * @var FwRouter
     */
    private static $instance;

    /**
     * privateなコンストラクタ
     */
    private function __construct()
    {
        if (! isset($_SESSION)) {
            session_start();
        }
        $this->methods = array();
    }

    /**
     * インスタンス取得
     * セッション内にすでにインスタンスがあればそれを返す
     * セッション内にまだインスタンスがなければnewして返す
     *
     * @return FwRouter
     */
    public static function getInstance()
    {
        if (isset($_SESSION['router'])) {
            return $_SESSION['router'];
        }
        if (empty(self::$instance)) {
            self::$instance = new FwRouter();
        }
        $_SESSION['router'] = self::$instance;
        return $_SESSION['router'];
    }

    /**
     * 定義の追加
     * NOTE: テストしていない関数
     * TODO: テスト
     *
     * @param Method $method        'GET', 'POST', 'PUT' , 'DELETE'
     * @param string $path          '/', 'author/:id', etc
     * @param string $class_method  'IndexController@index', etc
     *
     * @return bool
     */
    public function add($method, $path, $class_method)
    {
        if ($instance = $this->getMethodInstance($method)) {
            return $instance->add($path, $class_method);
        }
        return false;
    }

    /**
     * URIとmethodにより、定義されているコントローラーの関数を呼ぶ
     *
     * @param Method  $method   'GET', 'POST', 'PUT' , 'DELETE'
     * @param string  $request  $_SERVER['REQUEST_URI']
     * @param integer $code     HTTP status code
     *
     * @return void
     */
    public function search($method, $request, $code = 200)
    {
        if (! $instance = $this->getMethodInstance($method)) {
            // 500エラー
            return header('Content-Type: text/plain; charset=UTF-8', true, 500);
        }
        $instance->search($request, $code);
    }

    /**
     * $methodに対応したインスタンスをすでに作成済みであれば作成済みのものを、未作成であれば新規に作成し返す
     *
     * @param Method $method 'GET', 'POST', 'PUT' , 'DELETE'
     *
     * @return AbstractFwRouter
     */
    private function getMethodInstance($method)
    {
        $instance = null;
        $method_str = $method->getMethod();
        if (isset($this->methods[$method_str])) {
            return $this->methods[$method_str];
        }

        $method_str = ucfirst(strtolower($method_str)); // 'GET' to 'Get'
        // 指定Methodの定義インスタンス
        $config_class = 'FW\Config\Router\\'.$method_str.'Config';
        // 指定Methodのルーターインスタンス
        $router_class_name = 'FW\Helper\Request\Fw'.$method_str.'Router';
        $instance = new $router_class_name($config_class::getConf());
        // ルーターインスタンスをSingletonで保持
        $this->methods[$method_str] = $instance;
        $_SESSION['router'] = self::$instance;

        return $instance;
    }
}
