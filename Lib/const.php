<?php

define("APP_NAME", "Twitter");
define("SITE_URL", "http://" . $_SERVER["HTTP_HOST"]);
define('DSN', 'mysql:host=localhost;dbname=twitter');
define('DB_USERNAME', 'dbuser');
define('DB_PASSWORD', 'vagrantVagrant@123');
define('MAX_CHAR_LENGTH', 255);
define('MAX_TEXT_LENGTH', 140);
define('MAX_FILE_SIZE', 2 * 1024 * 1024);
define('ORIGIN_ICON_PATH', "/home/vagrant/Twitter/USER_DATA/ICON/ORIGIN");
define('ORIGIN_BACKGROUND_PATH', "/home/vagrant/Twitter/USER_DATA/BACKGROUND/ORIGIN");
define('THUMBNAIL_ICON_PATH', "/home/vagrant/Twitter/USER_DATA/ICON/THUMBNAIL");
define('THUMBNAIL_BACKGROUND_PATH', "/home/vagrant/Twitter/USER_DATA/BACKGROUND/THUMBNAIL");
define('THUMBNAIL_IMG_PATH', "/home/vagrant/Twitter/USER_DATA/IMG/THUMBNAIL");
define('THUMBNAIL_ICON_WIDTH', 100);
define('THUMBNAIL_BACKGROUND_WIDTH', 300);
define('THUMBNAIL_IMG_WIDTH', 300);
define('ORIGIN_IMG_PATH', "/home/vagrant/Twitter/USER_DATA/IMG/ORIGIN");
define('REQUEST_SEND_POST', 1);
define('REQUEST_GET_ALL_POST', 2);
define('REQUEST_GET_SELF_POST', 3);
define('REQUEST_EDIT_PROFILE', 4);
