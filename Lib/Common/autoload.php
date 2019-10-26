<?php

require_once(__DIR__ . '/../const.php');

spl_autoload_register(function($class) {

  //自前クラスか判定(ライブラリなどの外部クラスの場合はrequireしない)
  if (strpos($class, APP_NAME) !== 0) {
    return;
  }

  //プロジェクトルートフォルダパス取得
  $rootfolderpath = substr(__DIR__, 0, (strpos(__DIR__, APP_NAME) + strlen(APP_NAME)));
  //インクルードパス生成
  $classfilepath = $rootfolderpath . str_replace('\\', '/', substr($class, strlen(APP_NAME)) . '.php');


  if (file_exists($classfilepath)) {
    require_once($classfilepath);
  }
});
