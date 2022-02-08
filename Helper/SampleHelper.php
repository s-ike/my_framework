<?php
namespace FW\Helper;

class SampleHelper
{
    private function __construct()
    {
    }

        /**
     * パンくずリスト作成
     * １階層のみ想定（トップ/現在のページ）
     *
     * @param string $title 現在のページタイトル
     *
     * @return string パンくずのHTML
     */
    public static function createBreadcrumb($title)
    {
        $top_url = self::getRootUrl();

        $code = <<<EOL
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="{$top_url}">トップ</a>
      </li>
      <li class="breadcrumb-item active">{$title}</li>
    </ol>
EOL;
        return $code;
    }

    /**
     * htmlspecialchars short function
     *
     * @param string $str
     *
     * @return string
     */
    public static function h($str)
    {
        return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
    }

    /**
     * トップページURLを取得
     *
     * @return string
     */
    public static function getRootUrl()
    {
        return (empty($_SERVER["HTTPS"]) ? "http://" : "https://").$_SERVER["HTTP_HOST"].FW_TOP_URL;
    }
}
