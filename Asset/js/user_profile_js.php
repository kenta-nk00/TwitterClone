<?php
require_once(__DIR__ . "/../../Lib/config.php");
require_once(__DIR__ . "/main_js.php");

 ?>

<script>
'use strict'

function moduleCall(token, user_id) {
  setActionBarIcon(token);
  getUserProfile(token, user_id);
  getSelfTweets(token, user_id);
  getFollow(token, user_id);
  getFollower(token, user_id);
  isFollow(token, user_id);
}

function getSelfTweets(token, user_id) {
  $.ajax( {
    url : "../../Controller/Main/Main_Accept.php",
    type : "POST",
    data : {
      token : token,
      id : <?php echo h(REQUEST_GET_POST); ?>,
      user_id : user_id
    },
  }).done(function(data) {

    if(data !== "[]") {
      reloadPosts(JSON.parse(data));
    }

  }).fail(function(data) {

  });
}

function getUserProfile(token, user_id) {
  $.ajax( {
    url : "../../Controller/Main/Main_Accept.php",
    type : "POST",
    data : {
      token : token,
      id : <?php echo h(REQUEST_GET_PROFILE); ?>,
      user_id : user_id
    },
  }).done(function(data) {

    if(data !== "false") {
      setProfile(JSON.parse(data));
    }

  }).fail(function(data) {

  });
}

function addFollow(token, user_id) {
  $.ajax( {
    url : "../../Controller/Main/Main_Accept.php",
    type : "POST",
    data : {
      token : token,
      id : <?php echo h(REQUEST_ADD_FOLLOW); ?>,
      user_id : user_id
    },
  }).done(function(data) {

    const intaract_button = document.getElementById("intaract_button");
    while(intaract_button.firstChild) {
      intaract_button.removeChild(intaract_button.firstChild);
    }

    const token = "<?php echo h($_SESSION['token']); ?>";
    const user_id = "<?php echo h($_COOKIE['user_id']); ?>";

    isFollow(token, user_id);
    getFollow(token, user_id);
    getFollower(token, user_id);

  }).fail(function(data) {

  });
}

function removeFollow(token, user_id) {
  $.ajax( {
    url : "../../Controller/Main/Main_Accept.php",
    type : "POST",
    data : {
      token : token,
      id : <?php echo h(REQUEST_REMOVE_FOLLOW); ?>,
      user_id : user_id
    },
  }).done(function(data) {

    const intaract_button = document.getElementById("intaract_button");
    while(intaract_button.firstChild) {
      intaract_button.removeChild(intaract_button.firstChild);
    }

    const token = "<?php echo h($_SESSION['token']); ?>";
    const user_id = "<?php echo h($_COOKIE['user_id']); ?>";

    isFollow(token, user_id);
    getFollow(token, user_id);
    getFollower(token, user_id);
    
  }).fail(function(data) {

  });
}

function isFollow(token, user_id) {
  $.ajax( {
    url : "../../Controller/Main/Main_Accept.php",
    type : "POST",
    data : {
      token : token,
      id : <?php echo h(REQUEST_IS_FOLLOW); ?>,
      user_id : user_id
    },
  }).done(function(data) {
      setButton(JSON.parse(data));
  }).fail(function(data) {

  });
}

function setProfile(data) {
  const user_name = document.getElementById("user_name");
  user_name.innerHTML = data.u_name;

  const user_background_img = document.getElementById("user_background_img");

  if(data.u_background === null) {
    user_background_img.setAttribute("src", "<?php echo h(ORIGIN_BACKGROUND_PATH); ?>" + "/default.png");
  } else {
    user_background_img.setAttribute("src", "<?php echo h(ORIGIN_BACKGROUND_PATH); ?>" + "/" + data.u_background);
  }

  const user_icon_img = document.getElementById("user_icon_img");

  if(data.u_icon === null) {
    user_icon_img.setAttribute("src", "<?php echo h(ORIGIN_ICON_PATH); ?>" + "/default.png");
  } else {
    user_icon_img.setAttribute("src", "<?php echo h(ORIGIN_ICON_PATH); ?>" + "/" + data.u_icon);
  }

  const u_name = document.getElementById("u_name");
  u_name.textContent = data.u_name;

  const u_profile = document.getElementById("u_profile");
  u_profile.innerHTML = data.u_profile;
}

function setButton(data) {
  const intaract_button = document.getElementById("intaract_button");
  const token = "<?php echo h($_SESSION['token']); ?>";
  const user_id = "<?php echo h($_COOKIE['user_id']); ?>";

  if(data.flag === "1") {
    const rm_follow_button = document.createElement("button");
    rm_follow_button.id = "rm_follow_button";
    intaract_button.appendChild(rm_follow_button);

    rm_follow_button.addEventListener("click", function() {
      removeFollow(token, user_id);
    });
  } else {
    const follow_button = document.createElement("button");
    follow_button.id = "follow_button";
    follow_button.innerHTML = "フォロー";
    intaract_button.appendChild(follow_button);

    follow_button.addEventListener("click", function() {
      addFollow(token, user_id);
    });
  }
}

</script>
