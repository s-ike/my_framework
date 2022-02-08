<?php
namespace FW\Helper\Request;

class FwGetRouter extends AbstractFwRouter
{
    /**
     * GETリクエストのsearch
     *
     * @param string $request_uri $_SERVER['REQUEST_URI']
     * @param int    $code        HTTP status code
     *
     * @return void
     */
    public function search($request_uri, $code = 200)
    {
        // $_SERVER['REQUEST_URI']をパースし、blog/以降を$dirsに入れる
        $dirs = $this->perthUri($request_uri);
        // 定義からマッチするものを取得
        $conf = $this->searchInConf($dirs);

        $params = null;
        if (! $conf) {
            $this->show404($request_uri);
            // header("HTTP/1.0 404 Not Found");
            // exit;
        }
        // $class_methodから$dirsのパラメータ部分を配列で抽出
        $params = $this->extractParams($conf, $dirs);

        // $class_methodに定義されたコントローラの関数を呼び出す
        $class_method = $conf[1];
        $this->view($class_method, $code, $params);
        exit;
    }

    private function show404($request_uri)
    {
        $this->view('ErrorController@show404', 404, $request_uri);
        exit;
    }
}
