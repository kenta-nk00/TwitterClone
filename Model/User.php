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

  // ユーザー登録処理
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

}
