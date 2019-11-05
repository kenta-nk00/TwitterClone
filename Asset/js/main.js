'use strict'

function sendPost(token, sendid, getid, text) {
  $.ajax( {
    url : "../../Controller/Main/Main_Accept.php",
    type : "POST",
    data : {
      token : token,
      id : sendid,
      text : text
    }
  }).done(function(data) {
    clearPosts();
    getAllPost(token, getid);

  }).fail(function(data) {

  });
}

function getAllPost(token, id) {
  $.ajax( {
    url : "../../Controller/Main/Main_Accept.php",
    type : "POST",
    data : {
      token : token ,
      id : id
    },
  }).done(function(data) {

    if(data !== "[]") {
      reloadPosts(JSON.parse(data));
    }

  }).fail(function(data) {

  });
}

function getSelfTweets(token, id) {
  $.ajax( {
    url : "../../Controller/Main/Main_Accept.php",
    type : "POST",
    data : {
      token : token ,
      id : id
    },
  }).done(function(data) {

    if(data !== "[]") {
      reloadPosts(JSON.parse(data));
    }

  }).fail(function(data) {

  });
}

function reloadPosts(posts) {
  for(let i = 0; i < posts.length; i++) {
    const post_root_ul = document.getElementById("post_root_ul");

    const post_frame = document.createElement("li");
    post_frame.setAttribute("class", "post_frame");

    const post_img = document.createElement("div");
    post_img.setAttribute("class", "post_img");

    const post_name = document.createElement("div");
    post_name.setAttribute("class", "post_name");
    post_name.textContent = posts[i].u_name;

    const post_text = document.createElement("div");
    post_text.setAttribute("class", "post_text");
    post_text.textContent = posts[i].p_text;

    post_frame.appendChild(post_img);
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
