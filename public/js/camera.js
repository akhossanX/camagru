'use strict';

function $(selector) {
    return document.querySelector(selector)
}

function stream_init() {
    if (navigator.mediaDevices.getUserMedia) {
        navigator.mediaDevices.getUserMedia(constraints)
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

function onStickerClick() {
    var img = document.createElement('img')
    img.style.position = 'absolute';
    img.style.left = leftCorner + 'px'
    img.style.top = topCorner + 'px'
    img.style.width = '100px';
    img.style.height = '100px';
    img.src = this.src
    img.ondblclick = OnStickerDoubleClick
    img.onmousedown = onStickerMouseDown
    img.onmousemove = onStickerMouseMove
    img.onmousemove = onStickerMouseUp
    video.insertAdjacentElement('afterEnd', img)
}

function OnStickerDoubleClick() {
    this.remove()
}

function onStickerMouseUp() {
    if (isdown === true) {
        console.log('Mouse Up\n')
        isdown = false
    }
}

function onStickerMouseDown() {
    // console.log(this.offsetLeft)
    // console.log(this.offsetTop)
    isdown = true

    console.log('Mouse Down\n')
}

function onStickerMouseMove() {
    event.preventDefault();
    if (isdown === true) {
        console.log("Mouse Move \n")
        console.log(event.clientX)
        console.log(event.clientY)
        this.style.left += event.clientX - parseInt(this.style.left) + 'px' 
        this.style.top += event.clientY - parseInt(this.style.top) + 'px'
        console.log(this.style.left)
        console.log(this.style.top)
    }
}


var video = $('#video-id'),
    videoContainer = document.getElementById('video-container-id')


var styles = window.getComputedStyle(videoContainer, null)
var width = parseInt(styles.getPropertyValue('width'))
var height = parseInt(styles.getPropertyValue('height'))

// console.log(width)
// console.log(height)

var constraints = {
    video: {
        width: width - 8,
        height: height - 8
    }
}

stream_init()


var stickers = document.querySelectorAll('#stickers img')

var topCorner = 100, leftCorner = 100

stickers.forEach(sticker => sticker.onclick = onStickerClick)

var isdown = false

    