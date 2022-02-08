<?php
namespace FW\Config\Database;

use FW\Config\Database\DatabaseConfig as DC;

class ArrayToDatabaseConfig
{
    /**
     * $this->confへDtabaseConfigインスタンをセット
     *
     * @param array $conf
     *
     * @return DatabaseConfig
     */
    public static function setConf($conf_array)
    {
        if (! self::validConf($conf_array)) {
            throw new \InvalidArgumentException('DatabaseConfig constractor error');
        }

        return self::toDatabaseConfigInstanceFromArray($conf_array);
    }

    /**
     * 各conf配列のバリデーション
     *
     * @param array $conf
     *
     * @return bool
     */
    private static function validConf($conf)
    {
        return (count($conf) && (isset($conf['value']) || isset($conf['dotenv'])));
    }

    /**
     * 設定配列からDatabaseConfigインスタンスを作成
     *
     * @param array $array
     *
     * @return DatabaseConfig
     */
    private static function toDatabaseConfigInstanceFromArray($array)
    {
        $value_array = array(
            DC::DB        => '',
            DC::DBHOST    => '',
            DC::DBUSER    => '',
            DC::DBPASS    => ''
        );
        if (isset($array['value'])) {
            $value_array = self::setConfValueToArray($array['value'], $value_array);
        }
        if (isset($array['dotenv'])) {
            $value_array = self::setConfValueToArray($array['dotenv'], $value_array, true);
        }
        return new DC(
            $value_array[DC::DB],
            $value_array[DC::DBHOST],
            $value_array[DC::DBUSER],
            $value_array[DC::DBPASS]
        );
    }

    /**
     * 設定配列の値を抽出
     *
     * @param array $array          設定配列
     * @param array $value_array    抽出配列
     * @param bool  $isDotenv       Dotenvの値を参照するのかどうか
     *
     * @return array 抽出配列
     */
    private static function setConfValueToArray($array, $value_array, $isDotenv = false)
    {
        if ($isDotenv) {
            try {
                // composer
                // $root = '/var/www/html/';
                $root = $_SERVER['DOCUMENT_ROOT'];
                require_once $root.'/vendor/autoload.php';

                $dotenv = new \Dotenv\Dotenv($root);
                $dotenv->load();    //.envが無いとエラーになる
            } catch (\Exception $e) {
                // do nothing in case the file doesn't exist
            }
        }

        foreach ($array as $key => $value) {
            $value_array[$key] = $isDotenv ? getenv($value) : $value;
        }

        return $value_array;
    }
}
