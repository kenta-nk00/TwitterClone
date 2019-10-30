<?php

namespace Twitter\Controller\Main;

class Home extends \Twitter\Controller\SessionController {

  public function run() {

    if($_SERVER["REQUEST_METHOD"] === "POST") {
      $this->postProcess();
    } else {
      header("Location: " . SITE_URL . "/View/Main/home.php");
      exit;
    }
  }

  private function postProcess() {

    // 正規のリクエストか確認
    try {
      $this->tokenValidate();
    } catch(\Twitter\Exception\InvalidToken $e) {
      $this->setErrors("token", $e->getMessage());
    }

    if($this->hasError()) {
      return;
    }

    switch($_POST["id"]) {
      case REQUEST_SEND_POST:
        $this->sendPost();
        break;
      case REQUEST_GET_POST:
        $this->getPosts();
        break;
    }
  }

  private function sendPost() {
    try {
      $this->textValidate();
    } catch(\Twitter\Exception\EmptyText $e) {
      $this->setErrors('text', $e->getMessage());
    } catch(\Twitter\Exception\InvalidText $e) {
      $this->setErrors('text', $e->getMessage());
    }

    if($this->hasError()) {
      return;
    }

    $userModel = new \Twitter\Model\User();

    $user = $userModel->sendTweet(array(
      "user_id" => $_SESSION["user"]["id"],
      "text" => $_POST["text"],
      "img" => empty($_POST["img"]) ? null : $_POST["img"],
      "date" => date("Y/m/d H:i:s")
    ));
  }

  private function getPosts() {
    $userModel = new \Twitter\Model\User();

    $user = $userModel->getTweets();

    header("conten-type: application/json; charset=utf8");
    echo json_encode($user);
  }

  private function textValidate() {
    if(!isset($_POST['text'])|| empty($_POST['text'])) {
      throw new \Twitter\Exception\EmptyText();
    }

    if(strlen($_POST['text']) > MAX_TEXT_LENGTH) {
      throw new \Twitter\Exception\InvalidText();
    }
  }

}
