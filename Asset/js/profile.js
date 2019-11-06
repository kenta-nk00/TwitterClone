'use strict'

function getSelfTweets(token) {
  $.ajax( {
    url : "../../Controller/Main/Main_Accept.php",
    type : "POST",
    data : {
      token : token,
      id : REQUEST_GET_SELF_POST
    },
  }).done(function(data) {

    if(data !== "[]") {
      reloadPosts(JSON.parse(data));
    }

  }).fail(function(data) {

  });
}

function toggleModalWindow() {
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
}

function previewImage(MAX_FILE_SIZE) {
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
    if(target_size > MAX_FILE_SIZE) {
      alert("画像サイズがオーバーしています。2MB以下の画像を選択してください。");
      return false;
    } else {
      return true;
    }
  }
}
