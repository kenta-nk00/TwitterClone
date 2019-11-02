<?php

require_once(__DIR__ . "/../../Lib/config.php");

isLogin();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>プロフィール</title>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
  <link rel="stylesheet" href="../../Asset/css/profile.css">
  <script type="text/javascript" src="../../Asset/jquery/jquery.min.js"></script>
  <script type="text/javascript" src="../../Asset/js/main.js"></script>

</head>
<body>
  <div id="container">

    <div class="icon">
      <i class="fab fa-twitter fa-2x home_icon"></i>
    </div>

    <div class="title">
      <p>プロフィール</p>
    </div>

    <div class="search">
      <p>検索</p>
    </div>

    <div class="action_bar">
      <ul>
        <li>
          <form action="./home.php" type="post" class="action_item">
            <button class="action_button home_button">ホーム</button>
          </form>
        </li>

        <li>
          <form action="" type="post" class="action_item">
            <button class="action_button message_button">メッセージ</button>
          </form>
        </li>

        <li>
          <form action="./profile.php" type="post" class="action_item">
            <button class="action_button profile_button">プロフィール</button>
          </form>
        </li>
      </ul>
    </div>

    <div class="profile">
      <div class="user_background"></div>

      <div class="user_icon"></div>

      <div class="user_profile"></div>

      <button　type="button" id="edit_button">プロフィールを編集</button>
    </div>

    <div class="post_list">
      <ul id="post_root_ul">
      </ul>

      <script>
        const token = "<?php echo h($_SESSION['token']); ?>"
        const id = "<?php echo h(REQUEST_GET_SELF_POST); ?>"
        getSelfTweets(token, id);
      </script>
    </div>

    <div class="recommend">
      <p>おすすめ</p>
    </div>

  </div>

  <div class="modal_window">
    <div id="mask"></div>
    <div id="modal">
      <form action="" method="post" id="edit_form">

        <div class="edit_header">
          <p>プロフィールを編集</p>
          <input type="submit" value="保存">
        </div>

        <div class="edit_background">
          <label>
            <input type="file" name="background" class="background_img">
          <label>
        </div>

        <div class="edit_icon">
          <label>
            <input type="file" name="icon" class="icon_img">
          <label>
        </div>

        <div class="edit_text">
          <p><label class="text_label">名前<input type="text" name="name" class="input_text"></label></p>

          <p><label class="text_label">自己紹介<input type="text" name="profile" class="input_text"></label></p>
        </div>

      </form>
    </div>

    <script>
      (function() {
        const edit_button = document.getElementById('edit_button');
        const mask = document.getElementById('mask');
        const modal = document.getElementById('modal');
        const form = document.getElementById('edit_form');

        edit_button.addEventListener("click", function() {
          mask.style.display = "inline";
          modal.style.display = "grid";
        });

        mask.addEventListener("click", function() {
          mask.style.display = "none";
          modal.style.display = "none";
        });
      })();
    </script>

  </div>

</body>
</html>
