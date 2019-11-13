<?php
require_once(__DIR__ . "/../../Lib/config.php");
require_once(__DIR__ . "/main_js.php");

 ?>

<script>
'use strict'

function moduleCall() {
  const token = "<?php echo h($_SESSION['token']); ?>";
  const user_id = <?php echo h($_SESSION["user_id"]); ?>;

  setActionBarIcon(token);
  getSelfProfile(token, user_id);
  getSelfTweets(token, user_id);
  getFollow(token, user_id);
  getFollower(token, user_id);
  setEventButton();
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

function getSelfProfile(token, user_id) {
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
      setModalInfo(JSON.parse(data));
    }

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

function setModalInfo(data) {
  const background_img = document.getElementById("background_img");

  if(data.u_background === null) {
    background_img.setAttribute("src", "<?php echo h(ORIGIN_BACKGROUND_PATH); ?>" + "/default.png");
  } else {
    background_img.setAttribute("src", "<?php echo h(ORIGIN_BACKGROUND_PATH); ?>" + "/" + data.u_background);
  }

  const icon_img = document.getElementById("icon_img");

  if(data.u_icon === null) {
    icon_img.setAttribute("src", "<?php echo h(ORIGIN_ICON_PATH); ?>" + "/default.png");
  } else {
    icon_img.setAttribute("src", "<?php echo h(ORIGIN_ICON_PATH); ?>" + "/" + data.u_icon);
  }

  const edit_name = document.getElementById("edit_name");
  edit_name.setAttribute("value", data.u_name);

  const edit_profile = document.getElementById("edit_profile");
  edit_profile.innerHTML = data.u_profile.replace(/<br>/g, "");
}

function setEventButton() {
  const edit_button = document.getElementById('edit_button');
  const mask = document.getElementById('mask');
  const modal = document.getElementById('modal');

  edit_button.addEventListener("click", function() {
    mask.style.display = "inline";
    modal.style.display = "grid";
  });

  mask.addEventListener("click", function() {
    mask.style.display = "none";
    modal.style.display = "none";
  });

  const background_file = document.getElementById('background_file');
  const icon_file = document.getElementById('icon_file');
  const background_img = document.getElementById('background_img');
  const icon_img = document.getElementById('icon_img');
  const save_button = document.getElementById('save_button');
  let background_img_size = 0;
  let icon_img_size = 0;

  save_button.addEventListener("click", function() {
    if(background_img_size > 0) {
      if(!checkImageSize(background_img_size)) {
        return;
      }
    }

    if(icon_img_size > 0) {
      if(!checkImageSize(icon_img_size)) {
        return;
      }
    }

    const edit_form = document.getElementById('edit_form');
    edit_form.submit();
  });

  background_file.addEventListener("change", function(e) {
    background_img_size = setImage(background_img, e);
  });

  icon_file.addEventListener("change", function(e) {
    icon_img_size = setImage(icon_img, e);
  });
}

function setImage(target, e) {
  const selectFiles = e.target.files;
  const fr = new FileReader();
  let size = 0;

  if(selectFiles.length !== 0) {
    fr.readAsDataURL(selectFiles[0]);
    size = selectFiles[0].size;
    fr.onload = function(e) {
      target.setAttribute("src", fr.result);
    }
  }

  return size;
}

function checkImageSize(target_size) {
  if(target_size > <?php echo h(MAX_FILE_SIZE); ?>) {
    alert("画像サイズがオーバーしています。2MB以下の画像を選択してください。");
    return false;
  } else {
    return true;
  }
}
</script>
