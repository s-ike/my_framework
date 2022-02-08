<?php
namespace FW\Templates\Items;

use ReflectionClass;
use FW\Templates\Items\ItemInterface;

abstract class Item implements ItemInterface
{
    protected $definitions;
    protected $template_file;

    public function __construct()
    {
        $this->definitions = array();
        // PHP5.3本番でエラー（5.4検証では問題なし）
        // $this->template_file = (new ReflectionClass($this))->getShortName().'Template.html';
        $this->template_file = 'ItemTemplate.html';
    }

    public function createHtml()
    {
        ob_start();
        $file = dirname(__FILE__).'/IncludeFiles/'.$this->template_file;
        require $file;
        $html = ob_get_contents();
        ob_end_clean();

        $pattern = '/{{(.*)}}/e';
        $param = $this->definitions;
        $replacement = '$param[\'$1\']';

        $html = preg_replace($pattern, $replacement, $html);

        return $html;
    }

    public function showHtml()
    {
        echo $this->createHtml();
    }
}
