<?php

require_once(__DIR__ . "/../../Lib/config.php");

isLogin();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>ホーム</title>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
  <link rel="stylesheet" href="../../Asset/css/home.css">
  <script type="text/javascript" src="../../Asset/jquery/jquery.min.js"></script>

</head>
<body>
  <div id="container">

    <div class="icon">
      <i class="fab fa-twitter fa-2x home_icon"></i>
    </div>

    <div class="title">
      <p>ホーム</p>
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
            <button class="action_button" id="profile_button">プロフィール</button>
          </form>
        </li>
      </ul>
    </div>

    <div class="post">
      <img id="user_icon">
      <input type="text" name="text" placeholder="いまどうしてる？" id="tweet_text">
      <button　type="button" id="tweet_button">ツイート</button>
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
    const REQUEST_SEND_POST = <?php echo h(REQUEST_SEND_POST); ?>;
    const REQUEST_GET_ALL_POST = <?php echo h(REQUEST_GET_ALL_POST); ?>;
    const ORIGIN_ICON_PATH = "<?php echo h(ORIGIN_ICON_PATH); ?>";
    const REQUEST_GET_PROFILE = "<?php echo h(REQUEST_GET_PROFILE); ?>";
  </script>

  <script type="text/javascript" src="../../Asset/js/main.js"></script>
  <script type="text/javascript" src="../../Asset/js/home.js"></script>

  <script>
    addProfileIcon(token);
    getSelfProfile(token);
    getAllPost(token);

    document.getElementById("tweet_button").addEventListener('click',
    function() {
      const text = document.getElementById("tweet_text").value;
      document.getElementById("tweet_text").value = "";
      sendPost(token, text);
    });
  </script>

</body>
</html>
