
'use strict';

let toggleMenu = () => {
    let navContent = document.getElementById('navbar-content');
    if (navContent.className === 'navbar-toggle') {
        navContent.className += ' toggle';
    } else {
        navContent.className = 'navbar-toggle';
    }
};

let like = document.querySelector(".like-icon"),
    unlike = document.querySelector(".unlike-icon");
    
let likeClick = function () {
    if (like.style.display === 'block') {
        like.style.display = 'none'
        unlike.style.display = 'block'
    } else {
        like.style.display = 'block'
        unlike.style.display = 'none'
    }
    
}
if (like && unlike) {
    like.addEventListener('click', likeClick);
    unlike.addEventListener('click', likeClick);
}
