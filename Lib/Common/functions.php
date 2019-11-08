<?php

/*
htmlspecialcharsのラッパー関数
*/
function h($s) {
  return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

function isLogin() {
  // ログインしていなければトップページに遷移
  if(!isset($_SESSION["user_id"])) {
    header("Location: " . SITE_URL);
    exit;
  }
}

function isSetCookie($name) {
  if(!isset($_COOKIE[$name])) {
    header("Location: " . SITE_URL . "/View/Main/home.php");
    exit;
  }
}

function tokenValidate() {
  if(!isset($_POST["token"]) || $_POST["token"] !== $_SESSION["token"]) {
    throw new \Twitter\Exception\InvalidToken();
  }
}

function nameValidate() {
  if(!isset($_POST['name'])|| empty($_POST['name'])) {
    throw new \Twitter\Exception\EmptyName();
  }

  if(mb_strlen($_POST['name']) > MAX_CHAR_LENGTH) {
    throw new \Twitter\Exception\InvalidName();
  }
}

function emailValidate() {
  if(!isset($_POST['email'])|| empty($_POST['email'])) {
    throw new \Twitter\Exception\EmptyEmail();
  }

  if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) || mb_strlen($_POST['email']) > MAX_CHAR_LENGTH) {
    throw new \Twitter\Exception\InvalidEmail();
  }
}

function passwordValidate() {
  if(!isset($_POST['password'])|| empty($_POST['password'])) {
    throw new \Twitter\Exception\EmptyPassword();
  }

  if(!preg_match("/^[a-zA-Z0-9]{8,100}$/", $_POST['password'])) {
    throw new \Twitter\Exception\InvalidPassword();
  }
}

function textValidate() {
  if(!isset($_POST['text'])|| empty($_POST['text'])) {
    throw new \Twitter\Exception\EmptyText();
  }

  if(mb_strlen($_POST['text']) > MAX_TEXT_LENGTH) {
    throw new \Twitter\Exception\InvalidText();
  }
}

function textAreaValidate($name) {
  if(!isset($_POST[$name])|| empty($_POST[$name])) {
    throw new \Twitter\Exception\EmptyProfile();
  }

  if(mb_strlen($_POST[$name]) > MAX_TEXT_LENGTH) {
    throw new \Twitter\Exception\InvalidProfile();
  }
}

function userIdValidate() {
  if(!isset($_POST["user_id"])|| empty($_POST["user_id"])) {
    throw new \Twitter\Exception\EmptyId();
  }

  if(!is_numeric($_POST["user_id"])) {
    throw new \Twitter\Exception\InvalidId();
  }
}
