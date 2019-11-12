<?php
require_once(__DIR__ . "/../../Lib/config.php");
require_once(__DIR__ . "/main_js.php");

 ?>

<script>
'use strict'

function getAllPost(token) {
  $.ajax( {
    url : "../../Controller/Main/Main_Accept.php",
    type : "POST",
    data : {
      token : token,
      id : <?php echo h(REQUEST_GET_ALL_POST); ?>
    },
  }).done(function(data) {

    if(data !== "[]") {
      reloadPosts(JSON.parse(data));
    }

  }).fail(function(data) {

  });
}

function sendPost(token, text) {
  $.ajax( {
    url : "../../Controller/Main/Main_Accept.php",
    type : "POST",
    data : {
      token : token,
      id : <?php echo h(REQUEST_SEND_POST); ?>,
      text : text
    }
  }).done(function(data) {
    clearPosts();
    getAllPost(token);

  }).fail(function(data) {

  });
}

function setTextAreaIcon(token) {
  $.ajax( {
    url : "../../Controller/Main/Main_Accept.php",
    type : "POST",
    data : {
      token : token,
      id : <?php echo h(REQUEST_GET_PROFILE); ?>,
      user_id : <?php echo h($_SESSION["user_id"]); ?>
    },
  }).done(function(data) {

    if(data !== "[]") {
      textarea_setIcon(JSON.parse(data));
    }

  }).fail(function(data) {

  });
}

function textarea_setIcon(data) {
  const user_icon = document.getElementById("user_icon");

  if(data.u_icon === null) {
    user_icon.setAttribute("src", "<?php echo h(ORIGIN_ICON_PATH); ?>" + "/default.png");
  } else {
    user_icon.setAttribute("src", "<?php echo h(ORIGIN_ICON_PATH); ?>" + "/" + data.u_icon);
  }
}
</script>
