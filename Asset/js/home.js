'use strict'

function sendPost(token, text) {
  $.ajax( {
    url : "../../Controller/Main/Main_Accept.php",
    type : "POST",
    data : {
      token : token,
      id : REQUEST_SEND_POST,
      text : text
    }
  }).done(function(data) {
    clearPosts();
    getAllPost(token);

  }).fail(function(data) {

  });
}

function getSelfProfile(token) {
  $.ajax( {
    url : "../../Controller/Main/Main_Accept.php",
    type : "POST",
    data : {
      token : token,
      id : REQUEST_GET_PROFILE
    },
  }).done(function(data) {

    if(data !== "[]") {
      setIcon(JSON.parse(data));
    }

  }).fail(function(data) {

  });
}

function setIcon(data) {
  const user_icon = document.getElementById("user_icon");

  if(data.u_icon === null) {
    user_icon.setAttribute("src", ORIGIN_ICON_PATH + "/default.png");
  } else {
    user_icon.setAttribute("src", ORIGIN_ICON_PATH + "/" + data.u_icon);
  }
}
