<?php

namespace Twitter\Controller;

class SessionController {

  public $_errors;

  public function __construct() {

    $this->_errors = Array();
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
