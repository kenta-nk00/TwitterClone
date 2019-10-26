<?php

require_once(__DIR__ . "/../Lib/config.php");

$app = new Twitter\Controller\Auth\LogOut();
$app->run();

 ?>
