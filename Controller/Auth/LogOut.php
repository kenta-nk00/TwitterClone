<?php

namespace Twitter\Controller\Auth;

class LogOut extends \Twitter\Controller\Auth\AuthController {

  public function run() {

    // ログインしていなければトップに遷移
    if(!isset($_SESSION["user"])) {
      header("Location: " . SITE_URL);
      exit;
    }

    if($_SERVER["REQUEST_METHOD"] === "POST") {
      $this->postProcess();
    } else {
      header("Location: " . SITE_URL . "/View/Main/home.php");
      exit;
    }

  }

  private function postProcess() {
    $this->validate();

    if($this->hasError()) {
      retun;
    }

    // セッション変数削除
    $_SESSION = [];

    // クッキー削除
    if(isset($_COOKIE[session_name()])) {
      setcookie(session_name(), '', time() - 1, "/");
    }

    // セッション削除
    session_destroy();

    // ログアウトが完了したらトップ画面に遷移
    header("Location: " . SITE_URL);
    exit;
  }

  // フォーム送信内容チェック
  private function validate() {
    try {
      $this->tokenValidate();
    } catch(\Twitter\Exception\InvalidToken $e) {
      $this->setErrors("token", $e->getMessage());
    }
  }
}
