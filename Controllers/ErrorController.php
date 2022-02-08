<?php
namespace FW\Controllers;

use FW\Templates\PageDefine;
use FW\Controllers\AbstractController;

class ErrorController extends AbstractController
{
    protected $definitions;
    protected $template;

    public function __construct()
    {
    }

    /**
     * 404ページ表示
     *
     * @param string  $param リクエストされたURI
     * @param integer $code
     *
     * @return void
     */
    public function show404($param, $code = 404)
    {
        // URL ////////////////////////////////////////////
        $blog_root_url = (empty($_SERVER["HTTPS"]) ? "http://" : "https://").$_SERVER["HTTP_HOST"].FW_TOP_URL;

        // ページ表示 //////////////////////////////////////
        $head_title = FW_SITE_TITLE.'|ページが見つかりません';

        // ページ設定 //////////////////////////////////////
        $definitions = new PageDefine(
            $head_title,
            $head_title,
            'website',
            "https://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"],
            $blog_root_url
        );
        // テンプレート使用用意
        $this->setDefinitionsAndTemplate($definitions);

        // ページ表示 //////////////////////////////////////
        $data = array();
        $data['template'] = $this->template;
        $data['requested_uri'] = $param;
        $this->callViewFile('404', $data, $code);
        exit;
    }
}
