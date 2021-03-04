
'use strict';

const URLROOT = 'http://localhost:8080'
const LIKE_ICON = URLROOT + '/public/icons/heart.svg';
const NO_LIKE_ICON = URLROOT + '/public/icons/heart.svg';
const LIKE_ACTION_SAVE_URI = URLROOT + '/images/like';

let toggleMenu = () => {
    let navContent = document.getElementById('navbar-content');
    if (navContent.className === 'navbar-toggle') {
        navContent.className += ' toggle';
    } else {
        navContent.className = 'navbar-toggle';
    }
};
    
let likeClick = function () {
    let xhr = new XMLHttpRequest();
    let url = new URL(LIKE_ACTION_SAVE_URI);
    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-Type', 'application/json; charset=UTF-8');
    let obj = {
        id: this.id,
        // liked: this.classList.contains('like-icon') ? false : true
    }
    console.log(obj);
    xhr.send(JSON.stringify(obj));
    xhr.onload = () => {
        let res = JSON.parse(xhr.response);
        console.log('response: ');
        console.log(res);
        if ('redirectURL' in res) {
            window.location = res.redirectURL;
        } else {
            let icon = document.querySelector('.img-post #id_' + res.id + ' i');
            let likesCount = icon.nextElementSibling;
            if (res.liked === true) {
                icon.classList.add('bi-heart-fill');
                icon.classList.remove('bi-heart');
                likesCount.innerHTML = `${res.likes} likes.`;
            } else {
                icon.classList.add('bi-heart');
                icon.classList.remove('bi-heart-fill');
                likesCount.innerHTML = `${res.likes} likes.`;
            }
        }
    }
}

let like = document.querySelectorAll(".like-icon")
    
like.forEach(icon => {
    icon.addEventListener('click', likeClick);
});
