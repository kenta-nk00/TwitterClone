<?php

namespace Twitter\Controller\Auth;

require_once(__DIR__ . "/validate.php");

class Login extends \Twitter\Controller\SessionController {

  public function run() {
    // ログインしていればトップページに遷移
    if($this->isLoggedIn()) {
      header("Location: " . SITE_URL);
      exit;
    }

    if($_SERVER["REQUEST_METHOD"] === "POST") {
      $this->postProcess();
    }
  }

  private function postProcess() {
    $this->validate();

    if($this->hasError()) {
      return;
    }

    $userModel = new \Twitter\Model\User();

    try {
      $user = $userModel->logIn(array(
        "email" => $_POST["email"],
        "password" => $_POST["password"]
      ));
    } catch(\Twitter\Exception\NotFoundEmail $e) {
      $this->setErrors('email', $e->getMessage());
      return;
    } catch(\Twitter\Exception\UnmatchPassword $e) {
      $this->setErrors('password', $e->getMessage());
      return;
    }

    // セッション固定攻撃対策
    session_regenerate_id(true);

    // ログイン完了状態
    $_SESSION["user"] = array(
      "id" => $user["u_id"],
      "name" => $user["u_name"],
      "email" => $user["u_email"],
      "thumb" => $user["u_thumb"],
    );

    // ログインが完了したらトップ画面に遷移
    header("Location: " . SITE_URL);
    exit;
  }

  // フォーム送信内容チェック
  private function validate() {
    try {
      tokenValidate();
    } catch(\Twitter\Exception\InvalidToken $e) {
      $this->setErrors("token", $e->getMessage());
    }

    try {
      emailValidate();
    } catch(\Twitter\Exception\EmptyEmail $e) {
      $this->setErrors("email", $e->getMessage());
    } catch(\Twitter\Exception\InvalidEmail $e) {
      $this->setErrors("email", $e->getMessage());
    }

    try {
      passwordValidate();
    } catch(\Twitter\Exception\EmptyPassword $e) {
      $this->setErrors("password", $e->getMessage());
    } catch(\Twitter\Exception\InvalidPassword $e) {
      $this->setErrors("password", $e->getMessage());
    }
  }
}
