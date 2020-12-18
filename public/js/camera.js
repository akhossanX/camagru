'use strict';

var video = $('#video')


function $(selector) {
    return document.querySelector(selector)
}

function stream_init() {
    if (navigator.mediaDevices.getUserMedia) {
        navigator.mediaDevices.getUserMedia({video: true})
        .then(function (stream) {
            video.srcObject = stream
            video.play()
        })
        .catch(function (error){
            console.log(error)
            alert(error)
        })
    }
}

stream_init()

// img.src = 'https://assets.stickpng.com/images/580b585b2edbce24c47b2a1f.png'
// img.parentElement.style.position = 'relative';
// img.style.position = 'absolute';
// img.style.left = '0px';
// img.style.top = '0px';
// console.log(img.parentElement);
// console.log("parent: " + img.parentElement.offsetLeft + ", " + img.parentElement.offsetTop)
// console.log("img: " + img.offsetLeft + ", " + img.offsetTop)

var checkboxes = document.querySelectorAll('#stickers .form-check .form-check-input'),
    pngs = document.querySelectorAll('#stickers .form-check .form-check-label img')
    console.log(pngs)
    console.log(checkboxes)
var topCorner = 0, leftCorner = 0

function onStickerClick() {
    if (this.checked === true) {
        var img = document.createElement('img')
        img.style.position = 'absolute';
        img.style.left = leftCorner + 'px'
        img.style.top = topCorner + 'px'
        img.src = pngs[0].src
        leftCorner += 100
        topCorner += 100
        video.insertAdjacent('afterend', img.toString())
    }
}
var i
for (i = 0; i < checkboxes.length; i++) {
    checkboxes[i].onclick = onStickerClick
}
    