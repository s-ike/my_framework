<?php
namespace FW\Controllers;

use FW\Model\SampleModel;
use FW\Helper\SampleHelper;
use FW\Templates\PageDefine;
use FW\Controllers\AbstractController;

class IndexController extends AbstractController
{
    protected $definitions;
    protected $template;

    public function __construct()
    {
        // ページ設定 //////////////////////////////////////
        $root_url = SampleHelper::getRootUrl();

        $this->definitions = new PageDefine(
            FW_SITE_TITLE,
            'サンプルサイト | サンプルです',
            'website',
            $root_url,
            $root_url
        );
        $this->setDefinitionsAndTemplate($this->definitions);
    }

    /**
     * トップページ表示
     *
     * @param array     $params パラメータ（ページ番号）
     * @param integer   $code   HTTP status code
     *
     * @return void
     */
    public function showIndex($params = array(), $code = 200)
    {
        $contents = array();
        $contents[0] = array(
            "title" => "Project One",
            "description" => "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet numquam aspernatur eum quasi sapiente nesciunt? Voluptatibus sit, repellat sequi itaque deserunt, dolores in, nesciunt, illum tempora ex quae? Nihil, dolorem!"
        );
        $contents[1] = array(
            "title" => "Project Two",
            "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam viverra euismod odio, gravida pellentesque urna varius vitae."
        );
        $contents[2] = array(
            "title" => "Project Three",
            "description" => "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos quisquam, error quod sed cumque, odio distinctio velit nostrum temporibus necessitatibus et facere atque iure perspiciatis mollitia recusandae vero vel quam!"
        );
        $contents[3] = array(
            "title" => "Project Four",
            "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam viverra euismod odio, gravida pellentesque urna varius vitae."
        );
        $contents[4] = array(
            "title" => "Project Five",
            "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam viverra euismod odio, gravida pellentesque urna varius vitae."
        );
        $contents[5] = array(
            "title" => "Project Six",
            "description" => "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Itaque earum nostrum suscipit ducimus nihil provident, perferendis rem illo, voluptate atque, sit eius in voluptates, nemo repellat fugiat excepturi! Nemo, esse."
        );

        // ページ表示 //////////////////////////////////////
        $data = array();
        $data['contents'] = $contents;
        $data['template'] = $this->template;
        $this->callViewFile('Index', $data, $code);
    }
}
