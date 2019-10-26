<?php

namespace Twitter\Controller;

class SessionController {

  public $_errors;

  public function __construct() {

    // CSRFトークン生成
    if (!isset($_SESSION['token'])) {
        $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(16));
    }

    $this->_errors = Array();
  }

  // ログイン中状態をセッション変数"user"で表す
  protected function isLoggedIn() {
    return isset($_SESSION["user"]);
  }

  protected function setErrors($key, $message) {
    $this->_errors[$key] = $message;
  }

  public function getErrors($key) {
    return isset($this->_errors[$key]) ? $this->_errors[$key] : "";
  }

  protected function hasError() {
    return !empty($this->_errors);
  }

}
