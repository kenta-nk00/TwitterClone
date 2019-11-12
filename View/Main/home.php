<?php
require_once(__DIR__ . "/../../Lib/config.php");

isLogin();

require_once("../../Asset/js/main_js.php");
require_once("../../Asset/js/home_js.php");
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
      <i class="fab fa-twitter fa-2x home_icon" onclick="backHome()"></i>
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
          <form action="./self_profile.php" type="post" class="action_item">
            <button class="action_button" id="profile_button">プロフィール</button>
          </form>
        </li>
      </ul>
    </div>

    <div class="post">
      <img id="user_icon">
      <textarea name="text" placeholder="いまどうしてる？" id="tweet_text"></textarea>
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

    setActionBarIcon(token);
    setTextAreaIcon(token);
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
