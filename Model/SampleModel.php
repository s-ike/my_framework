<?php
namespace FW\Model;

use FW\Config\Database\SampleDatabaseConfig;

/**
 * サンプル用データベース処理
 */
class SampleModel extends AbstractModel
{
    /**
     * ブログ取得
     *
     * @param int $page  ページ番号
     * @param int $limit 取得する数
     *
     * @return array
     */
    public function getBlogs($page, $limit = 9)
    {
        $offset = 0 < $page ? ($page * $limit) - $limit : $page * $limit;

        $blog_sql = <<<SQL
SELECT *
    FROM blog
    ORDER BY published_at DESC
    LIMIT ?, ?;
SQL;

        $pdo = $this->connectThisDb();
        if ($pdo) {
            try {
                $stmt = $pdo->prepare($blog_sql);
                $stmt->execute(array($offset, $limit));
                $blogs = $stmt->fetchAll();
                return $blogs;
            } catch (\Exception $e) {
            }
        }
        // 500エラー
        $this->returnError();
        exit;
    }

    /**
     * ブログ用DB接続
     *
     * @return  成功:PDO 失敗:(bool)FALSE
     */
    protected function connectThisDb()
    {
        return $this->connectDb(new SampleDatabaseConfig());
    }
}
