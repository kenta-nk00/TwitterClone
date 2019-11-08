<?php

define("APP_NAME", "Twitter");
define("SITE_URL", "http://" . $_SERVER["HTTP_HOST"]);
define('DSN', 'mysql:host=localhost;dbname=twitter;charset=utf8;');
define('DB_USERNAME', 'dbuser');
define('DB_PASSWORD', 'vagrantVagrant@123');
define('MAX_CHAR_LENGTH', 255);
define('MAX_TEXT_LENGTH', 140);
define('MAX_FILE_SIZE', 2 * 1024 * 1024);
define('PROJECT_PATH', "/home/vagrant/Twitter");
define('ORIGIN_ICON_PATH', "/USER_DATA/ICON/ORIGIN");
define('ORIGIN_BACKGROUND_PATH', "/USER_DATA/BACKGROUND/ORIGIN");
define('THUMBNAIL_ICON_PATH', "/USER_DATA/ICON/THUMBNAIL");
define('THUMBNAIL_BACKGROUND_PATH', "/USER_DATA/BACKGROUND/THUMBNAIL");
define('THUMBNAIL_IMG_PATH', "/USER_DATA/IMG/THUMBNAIL");
define('THUMBNAIL_ICON_WIDTH', 100);
define('THUMBNAIL_BACKGROUND_WIDTH', 300);
define('THUMBNAIL_IMG_WIDTH', 300);
define('ORIGIN_IMG_PATH', "/USER_DATA/IMG/ORIGIN");
define('REQUEST_SEND_POST', 1);
define('REQUEST_GET_ALL_POST', 2);
define('REQUEST_GET_POST', 3);
define('REQUEST_EDIT_PROFILE', 4);
define('REQUEST_GET_PROFILE', 5);
define('REQUEST_SHOW_USER_PROFILE', 6);
define('REQUEST_FOLLOW_USER', 7);
define('REQUEST_UNFOLLOW_USER', 8);
