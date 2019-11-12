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
      case REQUEST_GET_POST:
        $this->getPost();
        break;
      case REQUEST_GET_PROFILE:
        $this->getProfile();
        break;
      case REQUEST_EDIT_PROFILE:
        $this->editProfile();
        break;
      case REQUEST_SHOW_USER_PROFILE:
        $this->showUserProfile();
        break;
      case REQUEST_ADD_FOLLOW:
        $this->addFollow();
        break;
      case REQUEST_GET_FOLLOW:
        $this->getFollow();
        break;
      case REQUEST_GET_FOLLOWER:
        $this->getFollower();
        break;
      case REQUEST_IS_FOLLOW:
        $this->isFollow();
        break;
      case REQUEST_REMOVE_FOLLOW:
        $this->removeFollow();
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
      "text" => nl2br($_POST["text"], false),
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

  private function getPost() {
    try {
      userIdValidate();
    } catch(\Twitter\Exception\EmptyId $e) {
      $this->setErrors("user_id", $e->getMessage());
      echo $e->getMessage();
    } catch(\Twitter\Exception\InvalidId $e) {
      $this->setErrors("user_id", $e->getMessage());
      echo $e->getMessage();
    }

    if($this->hasError()) {
      return;
    }

    $userModel = new \Twitter\Model\User();

    $user = $userModel->getPost($_POST["user_id"]);

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
      textAreaValidate("profile");
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

    if(!empty($_FILES["icon"]["name"])) {
      $icon = new \Twitter\Lib\Common\ImageUploader(
        "icon",
        PROJECT_PATH . ORIGIN_ICON_PATH,
        PROJECT_PATH . THUMBNAIL_ICON_PATH,
        PROJECT_PATH . THUMBNAIL_ICON_WIDTH
      );
      $icon_file_name = $icon->upload();
    }

    $background_file_name = "";

    if(!empty($_FILES["background"]["name"])) {
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
      "profile" => nl2br($_POST["profile"], false),
      "icon" => $icon_file_name !== "" ? $icon_file_name : $userModel->getProfile($_SESSION["user_id"])["u_icon"],
      "background" => $background_file_name !== "" ? $background_file_name : $userModel->getProfile($_SESSION["user_id"])["u_background"]
    ));

    header("Location: " . SITE_URL . "/View/Main/self_profile.php");
    exit;
  }

  private function getProfile() {
    try {
      userIdValidate();
    } catch(\Twitter\Exception\EmptyId $e) {
      $this->setErrors("user_id", $e->getMessage());
      echo $e->getMessage();
    } catch(\Twitter\Exception\InvalidId $e) {
      $this->setErrors("user_id", $e->getMessage());
      echo $e->getMessage();
    }

    if($this->hasError()) {
      return;
    }

    $userModel = new \Twitter\Model\User();
    $user = $userModel->getProfile(
      $_POST["user_id"]
    );

    header("conten-type: application/json; charset=utf8");
    echo json_encode($user);
  }

  private function showUserProfile() {
    try {
      userIdValidate();
    } catch(\Twitter\Exception\EmptyId $e) {
      $this->setErrors("user_id", $e->getMessage());
      echo $e->getMessage();
    } catch(\Twitter\Exception\InvalidId $e) {
      $this->setErrors("user_id", $e->getMessage());
      echo $e->getMessage();
    }

    if($this->hasError()) {
      return;
    }

    if(isset($_COOKIE["user_id"])) {
      setcookie("user_id", '', time() - 1, "/");
    }

    if($_SESSION["user_id"] === $_POST["user_id"]) {
      header("Location: " . SITE_URL . "/View/Main/self_profile.php");
      exit;
    } else {
      setcookie("user_id", $_POST["user_id"], time() + 3600 * 24, "/");
      header("Location: " . SITE_URL . "/View/Main/user_profile.php");
      exit;
    }
  }

  private function addFollow() {
    try {
      userIdValidate();
    } catch(\Twitter\Exception\EmptyId $e) {
      $this->setErrors("user_id", $e->getMessage());
      echo $e->getMessage();
    } catch(\Twitter\Exception\InvalidId $e) {
      $this->setErrors("user_id", $e->getMessage());
      echo $e->getMessage();
    }

    if($this->hasError()) {
      return;
    }

    $userModel = new \Twitter\Model\User();

    $userModel->addFollow(
      $_POST["user_id"]
    );
  }

  private function getFollow() {
    try {
      userIdValidate();
    } catch(\Twitter\Exception\EmptyId $e) {
      $this->setErrors("user_id", $e->getMessage());
      echo $e->getMessage();
    } catch(\Twitter\Exception\InvalidId $e) {
      $this->setErrors("user_id", $e->getMessage());
      echo $e->getMessage();
    }

    if($this->hasError()) {
      return;
    }

    $userModel = new \Twitter\Model\User();
    $user = $userModel->getFollow(
      $_POST["user_id"]
    );

    header("conten-type: application/json; charset=utf8");
    echo json_encode($user);
  }

  private function getFollower() {
    try {
      userIdValidate();
    } catch(\Twitter\Exception\EmptyId $e) {
      $this->setErrors("user_id", $e->getMessage());
      echo $e->getMessage();
    } catch(\Twitter\Exception\InvalidId $e) {
      $this->setErrors("user_id", $e->getMessage());
      echo $e->getMessage();
    }

    if($this->hasError()) {
      return;
    }

    $userModel = new \Twitter\Model\User();
    $user = $userModel->getFollower(
      $_POST["user_id"]
    );

    header("conten-type: application/json; charset=utf8");
    echo json_encode($user);
  }

  private function isFollow() {
    try {
      userIdValidate();
    } catch(\Twitter\Exception\EmptyId $e) {
      $this->setErrors("user_id", $e->getMessage());
      echo $e->getMessage();
    } catch(\Twitter\Exception\InvalidId $e) {
      $this->setErrors("user_id", $e->getMessage());
      echo $e->getMessage();
    }

    if($this->hasError()) {
      return;
    }

    $userModel = new \Twitter\Model\User();
    $flag = $userModel->isFollow(
      $_POST["user_id"]
    );

    header("conten-type: application/json; charset=utf8");
    echo json_encode($flag);
  }

  private function removeFollow() {
    try {
      userIdValidate();
    } catch(\Twitter\Exception\EmptyId $e) {
      $this->setErrors("user_id", $e->getMessage());
      echo $e->getMessage();
    } catch(\Twitter\Exception\InvalidId $e) {
      $this->setErrors("user_id", $e->getMessage());
      echo $e->getMessage();
    }

    if($this->hasError()) {
      return;
    }

    $userModel = new \Twitter\Model\User();

    $userModel->removeFollow(
      $_POST["user_id"]
    );
  }

}
