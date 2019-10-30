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

    $result = $stmt->execute([
      ":user_id" => $values["user_id"],
      ":text" => $values["text"],
      ":img" => $values["img"],
      ":date" => $values["date"]
    ]);
  }

  // 全ツイート取得処理
  public function getTweets() {
    $sql = "select u_name, p_text, p_img, p_comment, p_like, p_date, u_thumb  from posts inner join users on posts.p_user_id = users.u_id order by p_id desc";
    $stmt = $this->db->query($sql);

    $posts = "";

    if($stmt) {
      $posts = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    return $posts;
  }

}
