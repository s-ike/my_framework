<?php
namespace FW\Config\Router\Interfaces;

interface RouterConfigInterface
{
    /**
     * ルーティング定義取得
     *
     * @return array
     */
    public static function getConf();
}
