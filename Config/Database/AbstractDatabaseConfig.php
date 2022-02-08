<?php
namespace FW\Config\Database;

use Dotenv;
use FW\Config\Database\DatabaseConfig;
use FW\Config\Database\ArrayToDatabaseConfig;
use FW\Config\Database\Interfaces\DatabaseConfigInterface;

require_once dirname(__FILE__).'/../../fw_config/config.php';

abstract class AbstractDatabaseConfig implements DatabaseConfigInterface
{
    /**
     * 設定
     *
     * @var DatabaseConfig
     */
    private $conf;

    /**
     * 本番環境用設定
     *
     * @var array
     */
    protected $production_conf = array();

    /**
     * 開発環境用設定
     *
     * @var array
     */
    protected $dev_conf = array();

    /**
     * テスト環境用設定
     *
     * @var array
     */
    protected $test_conf = array();

    /**
     * $this->confと$this->dotenv_confへ値を入れる
     */
    public function __construct()
    {
        // 環境変数がなければtest環境ということにする
        $mode = defined('BLOG_SITE_SERVER_ENV') ? BLOG_SITE_SERVER_ENV : 'test';

        $conf_array = array();
        try {
            $conf_file = $mode.'_conf';
            $conf_array = $this->$conf_file;
            $this->conf = ArrayToDatabaseConfig::setConf($conf_array);
        } catch (\Exception $e) {
            //throw $th;
        }
    }

    /**
     * 接続設定取得
     *
     * @return DatabaseConfig
     */
    public function getConf()
    {
        return $this->conf;
    }
}
