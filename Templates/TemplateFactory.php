<?php
namespace FW\Templates;

use FW\Templates\PageDefine;
use FW\Templates\Items\Head;
use FW\Templates\Items\Header;
use FW\Templates\Items\Footer;
use FW\Templates\Items\FooterScripts;

/**
 * PageDefineで定義された情報を適宜使用しながら共通HTMLパーツ作成
 */
class TemplateFactory
{
    private $page_define;

    /**
     * constructor
     *
     * @param PageDefine $page_define PageDefineオブジェクト
     *
     * @return void
     */
    public function __construct($page_define)
    {
        $this->page_define = $page_define;
    }

    public function head()
    {
        return new Head($this->page_define);
    }

    public function header()
    {
        return new Header($this->page_define);
    }

    public function footer()
    {
        return new Footer();
    }

    public function footerscripts()
    {
        return new FooterScripts($this->page_define);
    }
}
