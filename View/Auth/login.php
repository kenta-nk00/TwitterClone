<?php

require_once(__DIR__ . "/../../Lib/config.php");

$app = new Twitter\Controller\Auth\LogIn();
$app->run();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>ログイン</title>
  <link rel="stylesheet" href="../../Asset/css/auth.css">
</head>
<body>

  <div id="container">
    <p><strong>TwitterCloneにログイン</strong></p>
    <form action="" method="post">
      <p class="err"><?php echo h($app->getErrors("token")); ?></p>

      <label>メール<input type="text" name="email" class="input_text"></label>
      <p class="err"><?php echo h($app->getErrors("email")); ?></p>

      <label>パスワード<input type="password" name="password" class="input_text"></label>
      <p class="err"><?php echo h($app->getErrors("password")); ?></p>

      <input type="hidden" value="<?php echo h($_SESSION["token"]); ?>" name="token">

      <input type="submit" value="ログイン" class="submit_button">
    </form>
  </div>
</body>
</html>
