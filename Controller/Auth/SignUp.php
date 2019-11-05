<?php

namespace Twitter\Controller\Auth;

class SignUp extends \Twitter\Controller\SessionController {

  public function run() {

    // ログインしていればホームに遷移
    if(isset($_SESSION["user_id"])) {
      header("Location: " . SITE_URL . "/View/Main/home.php");
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

    // データベース登録
    try {
      $userModel->signUp(array(
        "name" => $_POST["name"],
        "email" => $_POST["email"],
        "password" => $_POST["password"]
      ));
    } catch(\Twitter\Exception\DuplicateEmail $e) {
      $this->setErrors('email', $e->getMessage());
      return;
    }

    // 登録が完了したらログイン画面に遷移
    header("Location: " . SITE_URL . "/View/Auth/login.php");
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
      nameValidate();
    } catch(\Twitter\Exception\EmptyName $e) {
      $this->setErrors("name", $e->getMessage());
    } catch(\Twitter\Exception\InvalidName $e) {
      $this->setErrors("name", $e->getMessage());
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
