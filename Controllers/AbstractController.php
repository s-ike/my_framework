<?php
namespace FW\Controllers;

use FW\Templates\TemplateFactory;

abstract class AbstractController
{
    protected $definitions;
    protected $template;

    protected function setDefinitionsAndTemplate($definitions)
    {
        $this->definitions = $definitions;
        $this->template = new TemplateFactory($definitions);
    }

    protected function callViewFile($file, $data, $code = 200)
    {
        header('X-Powered-By: Unknown');
        if ($code !== 200) {
            switch ($code) {
                case 404:
                    header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
                    break;

                default:
                    header("Location: ", true, $code);
                    break;
            }
        }
        // Viewsディレクトリ内を整理するため、ディレクトリを作成しその中に表示用ファイルを作成する仕様
        //
        // namespaceを除いたクラス名取得
        $class  = basename(strtr(get_class($this), '\\', '/'));
        // クラス名から'Controller'より前の文字を取得しそれをディレクトリ名とする
        $dir    = strstr($class, 'Controller', true);
        require dirname(__FILE__).'/../Views/'.$dir.'/'.$file.'.php';
    }
}
