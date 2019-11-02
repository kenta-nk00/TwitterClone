<?php

define("APP_NAME", "Twitter");
define("SITE_URL", "http://" . $_SERVER["HTTP_HOST"]);
define('DSN', 'mysql:host=localhost;dbname=twitter');
define('DB_USERNAME', 'dbuser');
define('DB_PASSWORD', 'vagrantVagrant@123');
define('MAX_CHAR_LENGTH', 255);
define('MAX_TEXT_LENGTH', 140);
define('MAX_IMG_SIZE', 1 * 1024 * 1024);
define('THUMBNAIL_WIDTH', 300);
define('USER_ICON_PATH', "http://" . $_SERVER["HTTP_HOST"] . "/USER_DATA/ICON");
define('USER_IMG_PATH', "http://" . $_SERVER["HTTP_HOST"] . "/USER_DATA/IMG");

define('REQUEST_SEND_POST', 1);
define('REQUEST_GET_ALL_POST', 2);
define('REQUEST_GET_SELF_POST', 3);
