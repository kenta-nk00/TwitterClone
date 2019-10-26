<?php

function tokenValidate() {
  if(!isset($_POST["token"]) || $_POST["token"] !== $_SESSION["token"]) {
    throw new \Twitter\Exception\InvalidToken();
  }
}

function nameValidate() {
  if(!isset($_POST['name'])|| empty($_POST['name'])) {
    throw new \Twitter\Exception\EmptyName();
  }

  if(strlen($_POST['name']) > MAX_CHAR) {
    throw new \Twitter\Exception\InvalidName();
  }
}

function emailValidate() {
  if(!isset($_POST['email'])|| empty($_POST['email'])) {
    throw new \Twitter\Exception\EmptyEmail();
  }

  if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) || strlen($_POST['email']) > MAX_CHAR) {
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
