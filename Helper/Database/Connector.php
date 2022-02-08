<?php
namespace FW\Helper\Database;

use PDO;
use PDOException;
use FW\Config\Database\Interfaces\DatabaseConfigInterface;

class Connector
{
    /**
     * DatabaseConfig class instance
     *
     * @var DatabaseConfig
     */
    private $dbconfig;

    /**
     * POD options
     *
     * @var array
     */
    private $db_options;

    /**
     * コンストラクタ
     *
     * @param DatabaseConfigInterface $dbconfig_class
     */
    public function __construct(DatabaseConfigInterface $dbconfig_class)
    {
        $this->dbconfig = $dbconfig_class->getConf();

        $options = array(
            PDO::ATTR_ERRMODE               => PDO::ERRMODE_EXCEPTION,  // 例外をスロー
            PDO::ATTR_EMULATE_PREPARES      => false,                   // PDOクラスのエミュレーションを無効にする
            PDO::ATTR_DEFAULT_FETCH_MODE    => PDO::FETCH_ASSOC,        // カラム名をキーとする連想配列で取得する
        );
        // PHP5.3用
        if (defined('PDO::MYSQL_ATTR_READ_DEFAULT_FILE')) {
            $options[PDO::MYSQL_ATTR_READ_DEFAULT_FILE] = '/etc/my.cnf';
        }
        $this->db_options = $options;
    }

    /**
     * データベースに接続
     *
     * @return  成功:PDO 失敗:(bool)FALSE
     */
    public function connect()
    {
        $dsn = 'mysql:dbname='.$this->dbconfig->db.';host='.$this->dbconfig->db_host.';charset=utf8';
        try {
            $pdo = new PDO($dsn, $this->dbconfig->db_user, $this->dbconfig->db_pass, $this->db_options);
        } catch (PDOException $e) {
            return false;
        }
        return $pdo;
    }
}
