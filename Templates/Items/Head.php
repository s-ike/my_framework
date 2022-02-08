<?php
namespace FW\Templates\Items;

use ReflectionClass;
use FW\Templates\Items\Item;

class Head extends Item
{
    public function __construct($page_define)
    {
        $this->definitions = array();
        $this->definitions['title']         = $page_define->title;
        $this->definitions['description']   = $page_define->description;
        $this->definitions['type']          = $page_define->type;
        $this->definitions['url']           = $page_define->url;
        // TODO:
        $this->definitions['og_image']      = $page_define->top_url.'/images/og.png';
        $this->definitions['site_name']     = defined('FW_SITE_TITLE') ? FW_SITE_TITLE : 'サンプルサイト';
        $this->definitions['top_url']       = $page_define->top_url;

        // PHP5.3本番でエラー（5.4検証では問題なし）
        // $this->template_file = (new ReflectionClass($this))->getShortName().'Template.html';
        $this->template_file = 'HeadTemplate.html';
    }
}
