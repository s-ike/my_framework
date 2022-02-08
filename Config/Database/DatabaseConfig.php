<?php
namespace FW\Config\Database;

class DatabaseConfig
{
    const DB = 'db';
    const DBHOST = 'db_host';
    const DBUSER = 'db_user';
    const DBPASS = 'db_pass';

    /**
     * データベース名
     *
     * @var string
     */
    private $db;

    /**
     * データベースホスト名
     *
     * @var string
     */
    private $db_host;

    /**
     * データベースユーザー名
     *
     * @var string
     */
    private $db_user;

    /**
     * データベースユーザーのパスワード
     *
     * @var string
     */
    private $db_pass;

    /**
     * コンストラクタ
     *
     * @param string $db        データベース名
     * @param string $db_host   データベースホスト名
     * @param string $db_user   データベースユーザー名
     * @param string $db_pass   データベースユーザーのパスワード
     */
    public function __construct($db, $db_host, $db_user, $db_pass)
    {
        $this->setStrToVar(self::DB, $db);
        $this->setStrToVar(self::DBHOST, $db_host);
        $this->setStrToVar(self::DBUSER, $db_user);
        $this->setStrToVar(self::DBPASS, $db_pass);
    }

    /**
     * setter
     *
     * @param string $name  クラス変数名
     * @param string $value 値
     *
     * @return void
     */
    private function setStrToVar($name, $value)
    {
        $value = filter_var($value);
        if ($value === false) {
            throw new \InvalidArgumentException('DatabaseConfig error');
        }
        $this->$name = $value;
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
