<?php

namespace Twitter\Controller\Main;

class Main extends \Twitter\Controller\SessionController {

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
      tokenValidate();
    } catch(\Twitter\Exception\InvalidToken $e) {
      $this->setErrors("token", $e->getMessage());
      echo $e->getMessage();
    }

    if($this->hasError()) {
      return;
    }

    switch($_POST["id"]) {
      case REQUEST_SEND_POST:
        $this->sendPost();
        break;
      case REQUEST_GET_ALL_POST:
        $this->getAllPost();
        break;
      case REQUEST_GET_SELF_POST:
        $this->getSelfPost();
        break;
      case REQUEST_EDIT_PROFILE:
        $this->editProfile();
        break;
      case REQUEST_GET_PROFILE:
        $this->getSelfProfile();
        break;
    }
  }

  private function sendPost() {
    try {
      textValidate();
    } catch(\Twitter\Exception\EmptyText $e) {
      $this->setErrors('text', $e->getMessage());
      echo $e->getMessage();
    } catch(\Twitter\Exception\InvalidText $e) {
      $this->setErrors('text', $e->getMessage());
      echo $e->getMessage();
    }

    if($this->hasError()) {
      return;
    }

    $userModel = new \Twitter\Model\User();

    $user = $userModel->sendTweet(array(
      "user_id" => $_SESSION["user_id"],
      "text" => $_POST["text"],
      "img" => empty($_POST["img"]) ? null : $_POST["img"],
      "date" => date("Y/m/d H:i:s")
    ));
  }

  private function getAllPost() {
    $userModel = new \Twitter\Model\User();

    $user = $userModel->getAllPost();

    header("conten-type: application/json; charset=utf8");
    echo json_encode($user);
  }

  private function getSelfPost() {
    $userModel = new \Twitter\Model\User();

    $user = $userModel->getSelfPost();

    header("conten-type: application/json; charset=utf8");
    echo json_encode($user);
  }

  private function editProfile() {
    try {
      nameValidate();
    } catch(\Twitter\Exception\EmptyName $e) {
      $this->setErrors("name", $e->getMessage());
      echo $e->getMessage();
    } catch(\Twitter\Exception\InvalidName $e) {
      $this->setErrors("name", $e->getMessage());
      echo $e->getMessage();
    }

    try {
      profileValidate();
    } catch(\Twitter\Exception\EmptyProfile $e) {
      $this->setErrors("profile", $e->getMessage());
      echo $e->getMessage();
    } catch(\Twitter\Exception\InvalidProfile $e) {
      $this->setErrors("profile", $e->getMessage());
      echo $e->getMessage();
    }

    if($this->hasError()) {
      return;
    }

    $icon_file_name = "";

    if(!empty($_FILES["background"]["name"])) {
      $icon = new \Twitter\Lib\Common\ImageUploader(
        "icon",
        PROJECT_PATH . ORIGIN_ICON_PATH,
        PROJECT_PATH . THUMBNAIL_ICON_PATH,
        PROJECT_PATH . THUMBNAIL_ICON_WIDTH
      );
      $icon_file_name = $icon->upload();
    }

    $background_file_name = "";

    if(!empty($_FILES["icon"]["name"])) {
      $background = new \Twitter\Lib\Common\ImageUploader(
        "background",
        PROJECT_PATH . ORIGIN_BACKGROUND_PATH,
        PROJECT_PATH . THUMBNAIL_BACKGROUND_PATH,
        PROJECT_PATH . THUMBNAIL_BACKGROUND_WIDTH
      );
      $background_file_name = $background->upload();
    }

    $userModel = new \Twitter\Model\User();
    $userModel->editProfile(array(
      "user_id" => $_SESSION["user_id"],
      "name" => $_POST["name"],
      "profile" => $_POST["profile"],
      "icon" => $icon_file_name !== "" ? $icon_file_name : null,
      "background" => $icon_file_name !== "" ? $background_file_name : null
    ));

    header("Location: " . SITE_URL . "/View/Main/profile.php");
    exit;
  }

  private function getSelfProfile() {
    $userModel = new \Twitter\Model\User();

    $user = $userModel->getSelfProfile();

    header("conten-type: application/json; charset=utf8");
    echo json_encode($user);
  }
}
