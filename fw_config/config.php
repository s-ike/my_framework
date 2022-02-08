<?php
define('FW_SITE_TITLE', 'サンプルページ');
define('FW_TOP_URL', '');

// サーバー環境
if ($_SERVER['SERVER_ADDR'] === '200.100.100.100') {
    define('BLOG_SITE_SERVER_ENV', 'production');
} elseif ($_SERVER['SERVER_ADDR'] === '192.168.33.50') {
    define('BLOG_SITE_SERVER_ENV', 'dev');
} else {
    define('BLOG_SITE_SERVER_ENV', 'test');
}
