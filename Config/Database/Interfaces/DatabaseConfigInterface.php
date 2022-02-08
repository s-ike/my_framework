<?php
namespace FW\Config\Database\Interfaces;

interface DatabaseConfigInterface
{
    /**
     * ルーティング定義取得
     *
     * @return array
     */
    public function getConf();
}
