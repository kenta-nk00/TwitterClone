<?php

require_once(__DIR__ . "/../../Lib/config.php");

$app = new Twitter\Controller\Main\Main();

$app->run();
