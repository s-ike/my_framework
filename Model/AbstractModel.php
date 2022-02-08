<?php
namespace FW\Model;

use FW\Helper\Database\Connector;
use FW\Config\Database\Interfaces\DatabaseConfigInterface;

abstract class AbstractModel
{
    private $conector = null;

    abstract protected function connectThisDb();

    /**
     * DB接続
     *
     * @return 成功:PDO 失敗:(bool)FALSE
     */
    protected function connectDb(DatabaseConfigInterface $config)
    {
        if (! $this->conector) {
            $this->conector = new Connector($config);
        }

        return $this->conector->connect();
    }

    /**
     * エラー時処理
     */
    protected function returnError()
    {
        // 500エラー
        return header('Content-Type: text/plain; charset=UTF-8', true, 500);
        exit;
    }
}
