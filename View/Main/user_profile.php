<?php
require_once(__DIR__ . "/../../Lib/config.php");

isLogin();

isSetCookie("user_id");

require_once("../../Asset/js/main_js.php");
require_once("../../Asset/js/profile_js.php");
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>プロフィール</title>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
  <link rel="stylesheet" href="../../Asset/css/profile.css">
  <script type="text/javascript" src="../../Asset/jquery/jquery.min.js"></script>

</head>
<body>
  <div id="container">

    <div class="icon">
      <i class="fab fa-twitter fa-2x home_icon"></i>
    </div>

    <div class="title">
      <p id="user_name"></p>
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
          <form action="./self_profile.php" type="post" class="action_item">
            <button class="action_button" id="profile_button">プロフィール</button>
          </form>
        </li>
      </ul>
    </div>

    <div class="profile">
      <div class="user_background">
        <img id="user_background_img">
      </div>

      <div class="user_icon">
        <img id="user_icon_img">
      </div>

      <div class="user_profile">
        <div class="u_name">
          <p id="u_name"></p>
        </div>

        <div class="u_profile">
          <p id="u_profile"></p>
        </div>

        <div class="u_follow">
          <p id="u_follow"></p>フォロー
          <p id="u_follower"></p>フォロワー
        </div>
      </div>

      <button　type="button" class="interact_button" id="follow_button">フォローする</button>
    </div>

    <div class="post_list">
      <ul id="post_root_ul">
      </ul>
    </div>

    <div class="recommend">
      <p>おすすめ</p>
    </div>

  </div>

  <script>
    const token = "<?php echo h($_SESSION['token']); ?>";
    const user_id = "<?php echo h($_COOKIE['user_id']); ?>";

    setActionBarIcon(token);
    getUserProfile(token, user_id);
    getSelfTweets(token, user_id);

    const follow_button = document.getElementById("follow_button");
    follow_button.addEventListener("click", function() {
      followUser(token, user_id);
    });

  </script>

</body>
</html>
