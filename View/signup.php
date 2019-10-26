<?php

require_once(__DIR__ . "/../Lib/config.php");

$app = new Twitter\Controller\Auth\SignUp();
$app->run();

 ?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>会員登録</title>
  <link rel="stylesheet" href="./css/styles.css">
</head>
<body>

  <div id="container">

    <p><strong>アカウントを作成</strong></p>
    <form action="" method="post">
      <p class="err"><?php echo h($app->getErrors("token")); ?></p>

      <label>名前<input type="text" name="name" class="input_text"></label>
      <p class="err"><?php echo h($app->getErrors("name")); ?></p>

      <label>メール<input type="text" name="email" class="input_text"></label>
      <p class="err"><?php echo h($app->getErrors("email")); ?></p>

      <label>パスワード<input type="password" name="password" class="input_text"></label>
      <p class="err"><?php echo h($app->getErrors("password")); ?></p>

      <input type="hidden" value="<?php echo h($_SESSION["token"]); ?>" name="token">

      <p><input type="submit" value="登録する" class="submit_button"></p>
    </form>
  </div>

</body>
</html>
