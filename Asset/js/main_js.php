<?php
require_once(__DIR__ . "/../../Lib/config.php");

 ?>

<script>
'use strict'

function setActionBarIcon(token) {
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
      action_bar_setIcon(JSON.parse(data));
    }

  }).fail(function(data) {

  });
}

function getFollow(token, user_id) {
  $.ajax( {
    url : "../../Controller/Main/Main_Accept.php",
    type : "POST",
    data : {
      token : token,
      id : <?php echo h(REQUEST_GET_FOLLOW); ?>,
      user_id : user_id
    },
  }).done(function(data) {

    setFollowCount(JSON.parse(data));

  }).fail(function(data) {

  });
}

function getFollower(token, user_id) {
  $.ajax( {
    url : "../../Controller/Main/Main_Accept.php",
    type : "POST",
    data : {
      token : token,
      id : <?php echo h(REQUEST_GET_FOLLOWER); ?>,
      user_id : user_id
    },
  }).done(function(data) {

    setFollowerCount(JSON.parse(data));

  }).fail(function(data) {

  });
}

function showUserProfile(user) {
  let form = document.createElement("form");
  let token = document.createElement("input");
  let id = document.createElement("input");
  let user_id = document.createElement("input");

  form.method = "POST";
  form.action = "../../Controller/Main/Main_Accept.php";

  token.type = "hidden";
  token.name = "token";
  token.value = "<?php echo h($_SESSION['token']); ?>";

  id.type = "hidden";
  id.name = "id";
  id.value = <?php echo h(REQUEST_SHOW_USER_PROFILE); ?>;

  user_id.type = "hidden";
  user_id.name = "user_id";
  user_id.value = user.dataset.user_id;

  form.appendChild(token);
  form.appendChild(id);
  form.appendChild(user_id);

  document.body.appendChild(form);
  form.submit();
}

function reloadPosts(posts) {
  for(let i = 0; i < posts.length; i++) {
    const post_root_ul = document.getElementById("post_root_ul");

    const post_frame = document.createElement("li");
    post_frame.setAttribute("class", "post_frame");

    const post_icon = document.createElement("img");
    post_icon.setAttribute("class", "post_icon");
    post_icon.setAttribute("onclick", "showUserProfile(this)");
    post_icon.setAttribute("data-user_id", posts[i].u_id);

    if(posts[i].u_icon === null) {
      post_icon.setAttribute("src", "<?php echo h(ORIGIN_ICON_PATH); ?>" + "/default.png");
    } else {
      post_icon.setAttribute("src", "<?php echo h(ORIGIN_ICON_PATH); ?>" + "/" + posts[i].u_icon);
    }

    const post_name = document.createElement("div");
    const post_name_p = document.createElement("p");
    post_name.setAttribute("class", "post_name");
    post_name_p.setAttribute("class", "post_name_p");
    post_name_p.setAttribute("onclick", "showUserProfile(this)");
    post_name_p.setAttribute("data-user_id", posts[i].u_id);
    post_name_p.innerHTML = posts[i].u_name;

    const post_time_p = document.createElement("p");
    post_time_p.setAttribute("class", "post_time_p");
    post_time_p.innerHTML = posts[i].p_date;

    const post_text = document.createElement("div");
    post_text.setAttribute("class", "post_text");
    post_text.innerHTML = posts[i].p_text;

    const post_footer = document.createElement("div");
    post_footer.setAttribute("class", "post_footer");

    const comment_button = document.createElement("button");
    comment_button.setAttribute("class", "comment_button");

    const retweet_button = document.createElement("button");
    retweet_button.setAttribute("class", "retweet_button");

    const good_button = document.createElement("button");
    good_button.setAttribute("class", "good_button");

    post_name.appendChild(post_name_p);
    post_name.appendChild(post_time_p);
    post_frame.appendChild(post_icon);

    post_frame.appendChild(post_name);
    post_frame.appendChild(post_text);

    post_footer.appendChild(comment_button);
    post_footer.appendChild(retweet_button);
    post_footer.appendChild(good_button);
    post_frame.appendChild(post_footer);

    post_root_ul.appendChild(post_frame);
  }
}

function clearPosts() {
  const post_root_ul = document.getElementById("post_root_ul");

  while(post_root_ul.firstChild) {
    post_root_ul.removeChild(post_root_ul.firstChild);
  }
}

function action_bar_setIcon(data) {
  let path = "";

  if(data.u_icon === null) {
    path = "<?php echo h(ORIGIN_ICON_PATH); ?>" + "/default.png";
  } else {
    path = "<?php echo h(ORIGIN_ICON_PATH); ?>" + "/" + data.u_icon;
  }

  let css = '#profile_button:before {  content: "";  display:inline-block;  width: 18px;  height: 18px;  border-radius: 50%;  border: 2px solid #eee;  margin-right: 10px; background-size: contain;  vertical-align: middle;  background-image: url(' + path + '); }';

  let style = document.createElement('style');

  style.appendChild(document.createTextNode(css));

  const profile_button = document.getElementById("profile_button");
  profile_button.appendChild(style);
}

function setFollowCount(data) {
  const u_follow = document.getElementById("u_follow");

  if(data) {
    u_follow.innerHTML = data.follow;
  } else {
    u_follow.innerHTML = "0";
  }
}

function setFollowerCount(data) {
  const u_follower = document.getElementById("u_follower");

  if(data) {
    u_follower.innerHTML = data.follower;
  } else {
    u_follower.innerHTML = "0";
  }
}

function backHome() {
  location.href = "<?php echo h(SITE_URL . "/View/Main/home.php") ?>";
}

</script>
