<?php
namespace FW\Config\Router;

use FW\Config\Router\Interfaces\RouterConfigInterface;

class PostConfig implements RouterConfigInterface
{
    /**
     * ルーティング定義
     * array(
     *     '/:page' => 'IndexController@index'
     * );
     *
     * @var array
     */
    private static $conf = array(
        '/info/registration' => 'InfoController@postRegistration',
    );

    /**
     * ルーティング定義取得
     *
     * @return array
     */
    public static function getConf()
    {
        return self::$conf;
    }
}
