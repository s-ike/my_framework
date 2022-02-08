<?php
namespace FW\Templates;

class PageDefine
{
    private $title;
    private $description;
    private $type;
    private $url;
    private $top_url;

    /**
     * __construct
     *
     * @param string $title         このページのタイトル
     * @param string $description   このページの説明
     * @param string $type          このページのタイプ（article, blog ...）
     * @param string $url           このページの正規URL
     * @param string $top_url       このサイトのトップURL
     *
     * @return void
     */
    public function __construct($title, $description, $type, $url, $top_url)
    {
        $this->title        = $title;
        $this->description  = $description;
        $this->type         = $type;
        $this->url          = $url;
        $this->top_url      = $top_url;
    }

    /**
     * 全てのクラス変数のgetter
     *
     * @param string $name クラス変数名
     *
     * @return string
     */
    public function __get($name)
    {
        return $this->$name;
    }
}
