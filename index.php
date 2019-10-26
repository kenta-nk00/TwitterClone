<?php

require_once(__DIR__ . "/Lib/config.php");

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>トップ</title>
</head>
<body>
  <p>こんにちは　<?php echo h($_SESSION['user']["name"]); ?> さん</p>
  <a href="./View/signup.php">signup</a>
  <a href="./View/login.php">login</a>

  <form action="./View/logout.php" method="post">
    <input type="hidden" value="<?php echo h($_SESSION["token"]); ?>" name="token">
    <p><input type="submit" value="ログアウト" class="submit_button"></p>
  </form>
</body>
</html>
