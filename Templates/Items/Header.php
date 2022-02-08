<?php
namespace FW\Templates\Items;

use ReflectionClass;
use FW\Helper\SampleHelper;
use FW\Templates\Items\Item;

class Header extends Item
{
    public function __construct($page_define)
    {
        $this->definitions = array();
        $this->definitions['top_url'] = $page_define->top_url;

        // PHP5.3本番でエラー（5.4検証では問題なし）
        // $this->template_file = (new ReflectionClass($this))->getShortName().'Template.html';
        $this->template_file = 'HeaderTemplate.html';
    }
}
