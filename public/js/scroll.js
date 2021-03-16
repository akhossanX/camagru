"use strict";

const LAZY_LOAD_POSTS_URL = "http://localhost:8080/home/lazy-load";

let galleryContainer = document.querySelector("#gallery-container");

let postsOffset = 5; // there is 5 posts max first time the gallery view is rendered
let loadingAnimation = document.querySelector(".loading");
let enableListener = true;

window.addEventListener("scroll", event => {
    if (!enableListener)
        return ;
    const { scrollTop, scrollHeight, clientHeight } = document.documentElement;
    if (scrollTop + clientHeight >= scrollHeight - 5) {
        loadingAnimation.classList.add("show");
        enableListener = false;
        setTimeout(loadMorePosts, 1000);
    } else {
        loadingAnimation.classList.remove("show");
    }
});

const loadMorePosts = function () {
    // send http request to server and fetch a bucket of 5 posts at most
    const xhr = new XMLHttpRequest();
    const url = new URL(LAZY_LOAD_POSTS_URL);
    xhr.open("post", url, true);
    xhr.setRequestHeader("content-type", "application/json");
    xhr.send(JSON.stringify({ postsOffset }));
    xhr.onload = () => {
        const res = JSON.parse(xhr.response);
        const len = Object.keys(res).length;
        if (len !== 0) {
            // Add the data to the DOM
            res.forEach((post) => {
                let postSection = document.createElement("section");
                postSection.classList.add("img-post");
                postSection.innerHTML = getPostContent(post);
                loadingAnimation.classList.remove("show");
                galleryContainer.appendChild(postSection);
            });
            // increment offset by len (5 at most)
            postsOffset += 5;
            enableListener = true;
        } else {
            loadingAnimation.classList.remove("show");
        }
    };
}


const getPostContent = function (post) {
    let content = `
    <div class="user-pseudo">${post.image.owner}</div>
    <div class="ca-border" style="width:100%"></div>
    <div class="post">
        <img src="data:image/png;base64, ${post.image.data}" class="main-image">
        <input type="hidden" name="db-id" value="${post.image.imageid}">
    </div>
    <section class="post-infos"  id="id_${post.image.imageid}">
    `;
    if (post.liked == true) {
        content += `<i class="bi bi-heart-fill like-icon" id="${post.image.imageid}" onclick="like(event)"></i>`;
    } else {
        content += `<i class="bi bi-heart like-icon" id="${post.image.imageid}" onclick="like(event)"></i>`;
    }
    content += `
        <span class="likes-count"> ${post.likes.count} likes.</span>
    </section>
    <section class="post-comments">
        <div class="comment-display-area" id="comment-display-area-${post.image.imageid}">
    `;
    const comments = post.comments;
    comments.forEach (comment => {
        content += `
        <div class="comment-area">
            <h6 class="comment-pseudo">${comment.username}</h6>
            <p class="comment-text">${comment.text}</p>
        </div>
        `;
    });
    content += `
        </div>
        <div class="add-comment-area">
            <textarea name="comment" id="id_${post.image.imageid}" placeholder="add comment..."></textarea>
            <button 
                type="submit" 
                id="${post.image.imageid}" 
                class="btn btn-publish" 
                onclick="publishComment(event)"
            >
                publish
            </button>
        </div>
    </section>
    `;
    return content;
};
