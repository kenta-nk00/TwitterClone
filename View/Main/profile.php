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
            <button class="action_button" id="profile_button">プロフィール</button>
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

      </script>
    </div>

    <div class="recommend">
      <p>おすすめ</p>
    </div>

  </div>

  <div class="modal_window">
    <div id="mask"></div>
    <div id="modal">
      <form action="../../Controller/Main/Main_Accept.php" method="post" enctype="multipart/form-data" id="edit_form">

        <div class="edit_header">
          <p>プロフィールを編集</p>
          <button type="button" id="save_button">保存</button>
        </div>

        <div class="edit_background">
          <img id="background_img">
          <label><i class="fas fa-camera"></i>
            <input type="file" accept="image/*" name="background" id="background_file">
          <label>
        </div>

        <div class="edit_icon">
          <img id="icon_img">
          <label><i class="fas fa-camera"></i>
            <input type="file" accept="image/*" name="icon" id="icon_file">
          <label>
        </div>

        <div class="edit_text">
          <p><label class="text_label">名前<input type="text" name="name" class="input_text"></label></p>

          <p><label class="text_label">自己紹介<input type="text" name="profile" class="input_text"></label></p>
        </div>

        <input type="hidden" value="<?php echo h($_SESSION["token"]); ?>" name="token">
        <input type="hidden" value="<?php echo h(REQUEST_EDIT_PROFILE); ?>" name="id">
        <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo h(MAX_FILE_SIZE); ?>">

      </form>
    </div>
  </div>

  <script>
    const token = "<?php echo h($_SESSION['token']); ?>";
    const REQUEST_GET_SELF_POST = <?php echo h(REQUEST_GET_SELF_POST); ?>;
    const REQUEST_GET_PROFILE = "<?php echo h(REQUEST_GET_PROFILE); ?>";
    const ORIGIN_ICON_PATH = "<?php echo h(ORIGIN_ICON_PATH); ?>";
  </script>

  <script type="text/javascript" src="../../Asset/js/main.js"></script>
  <script type="text/javascript" src="../../Asset/js/profile.js"></script>

  <script>
    addProfileIcon(token);
    getSelfTweets(token);
    toggleModalWindow();
    previewImage(<?php echo h(MAX_FILE_SIZE); ?>);
  </script>

</body>
</html>
