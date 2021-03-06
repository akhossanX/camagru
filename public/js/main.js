
'use strict';

const URLROOT = 'http://localhost:8080'
const LIKE_ICON = URLROOT + '/public/icons/heart.svg';
const NO_LIKE_ICON = URLROOT + '/public/icons/heart.svg';
const LIKE_SAVE_URL = URLROOT + '/images/like';
const PUBLISH_COMMENT_URL = URLROOT + '/images/comment';
const DELETE_IMAGE_URL = URLROOT + '/images/delete'

var toggleMenu = () => {
    var navContent = document.getElementById('navbar-content');
    if (navContent.className === 'navbar-toggle') {
        navContent.className += ' toggle';
    } else {
        navContent.className = 'navbar-toggle';
    }
};
    
var like = function (e) {
    var xhr = new XMLHttpRequest();
    var url = new URL(LIKE_SAVE_URL);
    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-Type', 'application/json; charset=UTF-8');
    var obj = {id: e.target.id};
    xhr.send(JSON.stringify(obj));
    xhr.onload = () => {
        var res = JSON.parse(xhr.response);
        if ('redirectURL' in res) {
            window.location = res.redirectURL;
        } else {
            var icon = document.querySelector('.img-post #id_' + res.id + ' i');
            var likesCount = icon.nextElementSibling;
            if (res.liked === true) {
                icon.className = "bi bi-heart-fill like-icon";
                likesCount.innerHTML = `${res.likes} likes.`;
            } else {
                icon.className = "bi bi-heart like-icon";
                likesCount.innerHTML = `${res.likes} likes.`;
            }
        }
    }
}

var publishComment = function(e) {
    const id = e.target.id;
    const commentTextElement = document.querySelector(".post-comments textarea#id_" + id);
    if (commentTextElement.value.trim() === '')
        return null;
    const xhr = new XMLHttpRequest();
    const url = new URL(PUBLISH_COMMENT_URL);
    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-Type', 'application/json; charset=UTF-8');
    const obj = {
        imageid: id,
        commentText: commentTextElement.value
    }
    xhr.send(JSON.stringify(obj));
    xhr.onload = () => {
        const res = JSON.parse(xhr.response);
        if ('redirectURL' in res) {
            window.location = URLROOT + '/users/login';
            return ;
        }
        if (res.state === true) {
            const displayArea = document.querySelector("#comment-display-area-" + id);
            const container = document.createElement('div');
            container.classList.add("comment-area");
            const pseudo = document.createElement('h6');
            pseudo.classList.add("comment-pseudo");
            pseudo.innerText = res.username;
            const text = document.createElement('p');
            text.classList.add("comment-text");
            text.innerText = commentTextElement.value.trim();
            container.appendChild(pseudo);
            container.appendChild(text);
            displayArea.appendChild(container);
            commentTextElement.value = "";
        }
    }
}

var likeIcons = document.querySelectorAll(".like-icon")
likeIcons.forEach(icon => {
    icon.addEventListener('click', like);
});

var commentButtons = document.querySelectorAll('.add-comment-area button');
commentButtons.forEach(btn => {
    btn.addEventListener('click', publishComment);
});
