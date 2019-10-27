<?php

namespace Twitter\Controller\Auth;

class SignUp extends \Twitter\Controller\Auth\AuthController {

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
    header("Location: " . SITE_URL . "/View/login.php");
    exit;
  }

  // フォーム送信内容チェック
  private function validate() {
    try {
      $this->tokenValidate();
    } catch(\Twitter\Exception\InvalidToken $e) {
      $this->setErrors("token", $e->getMessage());
    }

    try {
      $this->nameValidate();
    } catch(\Twitter\Exception\EmptyName $e) {
      $this->setErrors("name", $e->getMessage());
    } catch(\Twitter\Exception\InvalidName $e) {
      $this->setErrors("name", $e->getMessage());
    }

    try {
      $this->emailValidate();
    } catch(\Twitter\Exception\EmptyEmail $e) {
      $this->setErrors("email", $e->getMessage());
    } catch(\Twitter\Exception\InvalidEmail $e) {
      $this->setErrors("email", $e->getMessage());
    }

    try {
      $this->passwordValidate();
    } catch(\Twitter\Exception\EmptyPassword $e) {
      $this->setErrors("password", $e->getMessage());
    } catch(\Twitter\Exception\InvalidPassword $e) {
      $this->setErrors("password", $e->getMessage());
    }
  }
}
