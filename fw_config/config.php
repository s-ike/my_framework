<?php
define('FW_SITE_TITLE', 'サンプルページ');
define('FW_TOP_URL', '');

// サーバー環境
if ($_SERVER['SERVER_ADDR'] === '202.181.101.78') {
    define('BLOG_SITE_SERVER_ENV', 'production');
} elseif ($_SERVER['SERVER_ADDR'] === '192.168.33.50') {
    define('BLOG_SITE_SERVER_ENV', 'dev');
} else {
    define('BLOG_SITE_SERVER_ENV', 'test');
}
