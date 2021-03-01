
'use strict';

const URLROOT = 'http://localhost:8080'
const LIKE_ICON = URLROOT + '/public/icons/heart.svg';
const NO_LIKE_ICON = URLROOT + '/public/icons/heart.svg';

let toggleMenu = () => {
    let navContent = document.getElementById('navbar-content');
    if (navContent.className === 'navbar-toggle') {
        navContent.className += ' toggle';
    } else {
        navContent.className = 'navbar-toggle';
    }
};
    
let likeClick = function () {
    if (this.style.className === 'like-icon') {
        console.log('like-icon')
        this.src = NO_LIKE_ICON;
        this.classList.add("unlike-icon");
        this.classList.remove("like-icon");
    } else {
        console.log('unlike-icon')
        this.src = LIKE_ICON;
        this.classList.add("like-icon");
        this.classList.remove("unlike-icon");
    }
}

let like = document.querySelectorAll(".like-icon"),
    unlike = document.querySelectorAll(".unlike-icon");

like.forEach(icon => {
    icon.addEventListener('click', likeClick);
});
unlike.forEach(icon => {
    icon.addEventListener('click', likeClick);
});
