<?php

namespace Twitter\Model;

class User {
  private $db;

  public function __construct() {
    try {
      $this->db = new \PDO(DSN, DB_USERNAME, DB_PASSWORD);
    } catch(\PDOException $e) {
      echo $e->getMessage();
      exit;
    }
  }

  // サインアップ処理
  public function signUp($values) {
    $sql = "insert into users(u_name, u_email, u_password) values(:name, :email, :password)";
    $stmt = $this->db->prepare($sql);

    $result = $stmt->execute([
      ":name" => $values["name"],
      ":email" => $values["email"],
      ":password" => password_hash($values["password"], PASSWORD_DEFAULT)
    ]);

    if(empty($result)) {
      throw new \Twitter\Exception\DuplicateEmail();
    }
  }

  // ログイン処理
  public function logIn($values) {
    $sql = "select * from users where u_email = :u_email";
    $stmt = $this->db->prepare($sql);

    $stmt->execute([
      ":u_email" => $values["email"]
    ]);

    $stmt->setFetchMode(\PDO::FETCH_ASSOC);
    $user = $stmt->fetch();

    if(empty($user)) {
      throw new \Twitter\Exception\NotFoundEmail();
    }

    // パスワード認証
    if(!password_verify($values["password"], $user["u_password"])) {
      throw new \Twitter\Exception\UnmatchPassword();
    }

    return $user;
  }

  // ツイート投稿処理
  public function sendTweet($values) {
    $sql = "insert into posts(p_user_id, p_text, p_img, p_date) values(:user_id, :text, :img, :date)";
    $stmt = $this->db->prepare($sql);

    $stmt->execute([
      ":user_id" => $values["user_id"],
      ":text" => $values["text"],
      ":img" => $values["img"],
      ":date" => $values["date"]
    ]);
  }

  // 全ツイート取得処理
  public function getAllPost() {
    $sql = "select u_id, u_name, u_icon, p_text, p_img, p_comment, p_like, p_date from posts inner join users on posts.p_user_id = users.u_id order by p_id desc";
    $stmt = $this->db->query($sql);

    $posts = "";

    if($stmt) {
      $posts = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    return $posts;
  }

  // ツイート取得処理
  public function getPost($user_id) {
    $sql = "select u_id, u_name, u_icon, p_text, p_img, p_comment, p_like, p_date from posts inner join users on posts.p_user_id = users.u_id and posts.p_user_id = :user_id order by p_id desc";
    $stmt = $this->db->prepare($sql);

    $result = $stmt->execute([
      ":user_id" => $user_id
    ]);

    $posts = "";

    if($result) {
      $posts = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    return $posts;
  }

  // プロフィール編集
  public function editProfile($values) {
    $sql = "update users set u_name=:name, u_profile=:profile, u_icon=:icon, u_background=:background where u_id=:user_id";
    $stmt = $this->db->prepare($sql);

    $stmt->execute([
      ":user_id" => $values["user_id"],
      ":name" => $values["name"],
      ":profile" => $values["profile"],
      ":icon" => $values["icon"],
      ":background" => $values["background"]
    ]);
  }

  // ユーザー情報取得
  public function getProfile($user_id) {
    $sql = "select u_id, u_name, u_profile, u_icon, u_background from users where u_id = :u_id";
    $stmt = $this->db->prepare($sql);

    $result = $stmt->execute([
      ":u_id" => $user_id
    ]);

    $posts = "";

    if($result) {
      $posts = $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    return $posts;
  }

  // フォロー数取得
  public function getFollow($user_id) {
    $sql = "select count(*) as follow from follows group by f_follower_id having f_follower_id = :user_id";
    $stmt = $this->db->prepare($sql);

    $result = $stmt->execute([
      ":user_id" => $user_id
    ]);

    $follower = "";

    if($result) {
      $follower = $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    return $follower;
  }

  // フォロワー数取得
  public function getFollower($user_id) {
    $sql = "select count(*) as follower from follows group by f_user_id having f_user_id = :user_id";
    $stmt = $this->db->prepare($sql);

    $result = $stmt->execute([
      ":user_id" => $user_id
    ]);

    $follower = "";

    if($result) {
      $follower = $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    return $follower;
  }

  // ユーザーフォロー
  public function addFollow($user_id) {
    $sql = "insert into follows(f_user_id, f_follower_id) select :user_id, :follower_id from dual where not exists(select * from follows where f_user_id = :user_id AND f_follower_id = :follower_id)";
    $stmt = $this->db->prepare($sql);

    $result = $stmt->execute([
      ":user_id" => $user_id,
      ":follower_id" => $_SESSION["user_id"]
    ]);
  }

  // フォローしているか
  public function isFollow($user_id) {
    $sql = "select exists(select * from follows where f_user_id = :user_id and f_follower_id = :follower_id) as flag";
    $stmt = $this->db->prepare($sql);

    $result = $stmt->execute([
      ":user_id" => $user_id,
      ":follower_id" => $_SESSION["user_id"]
    ]);

    $flag = "false";

    if($result) {
      $flag = $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    return $flag;
  }

  // フォロー解除
  public function removeFollow($user_id) {
    $sql = "delete from follows where f_user_id = :user_id and f_follower_id = :follower_id";
    $stmt = $this->db->prepare($sql);

    $result = $stmt->execute([
      ":user_id" => $user_id,
      ":follower_id" => $_SESSION["user_id"]
    ]);
  }

}
