'use strict'

function getAllPost(token, req_id) {
  $.ajax( {
    url : "../../Controller/Main/Main_Accept.php",
    type : "POST",
    data : {
      token : token,
      id : REQUEST_GET_ALL_POST
    },
  }).done(function(data) {

    if(data !== "[]") {
      reloadPosts(JSON.parse(data));
    }

  }).fail(function(data) {

  });
}

function addProfileIcon(token) {
  $.ajax( {
    url : "../../Controller/Main/Main_Accept.php",
    type : "POST",
    data : {
      token : token,
      id : REQUEST_GET_PROFILE
    },
  }).done(function(data) {

    if(data !== "[]") {
      addIcon(JSON.parse(data));
    }

  }).fail(function(data) {

  });
}

function reloadPosts(posts) {
  for(let i = 0; i < posts.length; i++) {
    const post_root_ul = document.getElementById("post_root_ul");

    const post_frame = document.createElement("li");
    post_frame.setAttribute("class", "post_frame");

    const post_icon = document.createElement("img");
    post_icon.setAttribute("class", "post_icon");

    if(posts[i].u_icon === null) {
      post_icon.setAttribute("src", ORIGIN_ICON_PATH + "/default.png");
    } else {
      post_icon.setAttribute("src", ORIGIN_ICON_PATH + "/" + posts[i].u_icon);
    }

    const post_name = document.createElement("div");
    post_name.setAttribute("class", "post_name");
    post_name.textContent = posts[i].u_name;

    const post_text = document.createElement("div");
    post_text.setAttribute("class", "post_text");
    post_text.textContent = posts[i].p_text;

    post_frame.appendChild(post_icon);
    post_frame.appendChild(post_name);
    post_frame.appendChild(post_text);

    post_root_ul.appendChild(post_frame);
  }
}

function clearPosts() {
  const post_root_ul = document.getElementById("post_root_ul");

  while(post_root_ul.firstChild) {
    post_root_ul.removeChild(post_root_ul.firstChild);
  }
}

function addIcon(data) {
  let path = "";

  if(data.u_icon === null) {
    path = ORIGIN_ICON_PATH + "/default.png";
  } else {
    path = ORIGIN_ICON_PATH + "/" + data.u_icon;
  }

  let css = '#profile_button:before {  content: "";  display:inline-block;  width: 18px;  height: 18px;  border-radius: 50%;  border: 1px solid #eee;  margin-right: 10px; background-size: contain;  vertical-align: middle;  background-image: url(' + path + '); }';

  let style = document.createElement('style');

  style.appendChild(document.createTextNode(css));

  const profile_button = document.getElementById("profile_button");
  profile_button.appendChild(style);
}
