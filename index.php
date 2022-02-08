<?php
namespace FW;

use FW\Helper\Request\Method;
use FW\Helper\Request\FwRouter;

require_once './vendor/autoload.php';
require_once './fw_config/config.php';

session_start();
session_regenerate_id(true);

$router = FwRouter::getInstance();
$method = isset($_SERVER['REQUEST_METHOD']) ? new Method($_SERVER['REQUEST_METHOD']) : new Method('GET');
$router->search($method, $_SERVER["REQUEST_URI"]);
exit;
