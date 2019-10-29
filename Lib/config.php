<?php

ini_set("display_errors", 1);

require_once(__DIR__ . "/const.php");
require_once(__DIR__ . "/Common/functions.php");
require_once(__DIR__ . "/Common/autoload.php");

session_start();

// CSRFトークン生成
if (!isset($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(16));
}
