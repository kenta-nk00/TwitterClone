<?php

/*
htmlspecialcharsのラッパー関数
*/
function h($s) {
  return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

function isLogin() {
  // ログインしていなければトップページに遷移
  if(!isset($_SESSION["user"])) {
    header("Location: " . SITE_URL);
    exit;
  }
}
