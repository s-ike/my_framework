<?php
namespace FW\Config\Database;

use FW\Config\Database\DatabaseConfig as DC;
use FW\Config\Database\AbstractDatabaseConfig;

class SampleDatabaseConfig extends AbstractDatabaseConfig
{
    /**
     * 設定の書き方
     *
     * classの前に以下をuse
     * use FW\Config\Database\DatabaseConfig as DC;
     *
     * classはAbstractDatabaseConfigをextendsする
     *
     * 以下3つの配列変数を宣言
     * protected $production_conf = array();
     * protected $dev_conf = array();
     * protected $test_conf = array();
     *
     * 各配列は各サーバ環境での設定
     *
     * 配列内にさらに配列を作る
     * 設定値をそのまま書く場合:
     * protected $production_conf = array(
     *  'value' => array(
     *      DC::DB => 'mydb',
     *      DC::DBHOST => '202.101.101.101',
     *      DC::DBUSER => 'user',
     *      DC::DBPASS => 'pass'
     *  )
     * );
     * 設定値をdotenvに書く場合:
     * protected $production_conf = array(
     *  'dotenv' => array(
     *      DC::DB => 'DEV_BLOG_DB',
     *      DC::DBHOST => 'DEV_BLOG_HOST',
     *      DC::DBUSER => 'DEV_BLOG_USER',
     *      DC::DBPASS => 'DEV_BLOG_PASS',
     *  )
     * );
     * ミックス:
     * protected $production_conf = array(
     *  'value' => array(
     *      DC::DB => 'mydb',
     *  ),
     *  'dotenv' => array(
     *      DC::DBHOST => 'DEV_BLOG_HOST',
     *      DC::DBUSER => 'DEV_BLOG_USER',
     *      DC::DBPASS => 'DEV_BLOG_PASS',
     *  )
     * );
     */

    /**
     * 本番環境用設定
     *
     * @var array
     */
    protected $production_conf = array(
        'value' => array(
            DC::DB => 'mydb',
            DC::DBHOST => '202.101.101.101',
            DC::DBUSER => 'user',
            DC::DBPASS => 'pass'
        )
    );

    /**
     * 開発環境用設定
     *
     * @var array
     */
    protected $dev_conf = array(
        'value' => array(
            DC::DB => 'mydb',
        ),
        'dotenv' => array(
            DC::DBHOST => 'DEV_BLOG_HOST',
            DC::DBUSER => 'DEV_BLOG_USER',
            DC::DBPASS => 'DEV_BLOG_PASS'
        )
    );

    /**
     * テスト環境用設定
     *
     * @var array
     */
    protected $test_conf = array();
}
