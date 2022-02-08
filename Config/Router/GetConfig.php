<?php
namespace FW\Config\Router;

use FW\Config\Router\Interfaces\RouterConfigInterface;

class GetConfig implements RouterConfigInterface
{
    /**
     * ルーティング定義
     * array(
     *      '/:page' => 'IndexController@index',
     *      '/info/registration' => 'InfoController@showRegistration',
     * );
     *
     * @var array
     */
    private static $conf = array(
        '/:page' => 'IndexController@showIndex',
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
