<?php
namespace FW\Templates\Items;

use ReflectionClass;
use FW\Templates\Items\Item;

class Footer extends Item
{
    public function __construct()
    {
        $this->definitions = array();
        // php.iniに書いてあれば不要
        date_default_timezone_set('Asia/Tokyo');
        $this->definitions['year'] = date('Y');

        // PHP5.3本番でエラー（5.4検証では問題なし）
        // $this->template_file = (new ReflectionClass($this))->getShortName().'Template.html';
        $this->template_file = 'FooterTemplate.html';
    }
}
