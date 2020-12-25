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

function onStickerClickChooser() {
    var img = document.createElement('img')
    img.style.position = 'absolute';
    img.style.left = leftCorner + 'px'
    img.style.top = topCorner + 'px'
    img.style.width = '100px';
    img.style.height = '100px';
    img.src = this.src
    img.ondblclick = OnStickerDoubleClick
    img.draggable = true
    img.id = '_' + Math.random().toString(36)
    img.ondragstart = onStickerDragStart
    img.ondragover = onStickerDragOver
    img.ondrop = onStickerDrop
    img.style.zIndex = zIndex++
    video.insertAdjacentElement('afterEnd', img)
}

function OnStickerDoubleClick() {
    this.remove()
}

function onStickerDragStart(event) {
    event.dataTransfer.setData('text/plain', this.id)
} 

function onStickerDragOver(event) {
    event.preventDefault()
    event.dataTransfer.dropEffect = 'move'
}

function onStickerDrop(event) {
    event.preventDefault()
    var liveSticker = document.getElementById(event.dataTransfer.getData('text/plain'))
    var mouseRelativePosition = {
        x: event.clientX + document.documentElement.scrollLeft - videoPosition.left,
        y: event.clientY + document.documentElement.scrollTop - videoPosition.top
    }
    var translationVector = {
        x: mouseRelativePosition.x - parseInt(liveSticker.style.left),
        y: mouseRelativePosition.y - parseInt(liveSticker.style.top)
    }
    var x = translationVector.x + parseInt(liveSticker.style.left) - 50,
        y = translationVector.y + parseInt(liveSticker.style.top) - 50
    liveSticker.style.left = x + 'px'
    liveSticker.style.top = y + 'px'
}

var video = $('#video-id'),
    videoContainer = document.getElementById('video-container-id'),
    zIndex = 1,
    styles = window.getComputedStyle(videoContainer, null),
    width = parseInt(styles.getPropertyValue('width')),
    height = parseInt(styles.getPropertyValue('height')),

    // 8 is the double of the video element's border size
    constraints = {
        video: {
            width: width - 8,
            height: height - 8
        }
    },
    stickers = document.querySelectorAll('#stickers img'),
    topCorner = 100, 
    leftCorner = 100

stream_init()

stickers.forEach(sticker => sticker.onclick = onStickerClickChooser)

video.ondrop = onStickerDrop
video.ondragover = onStickerDragOver

var videRect = video.getBoundingClientRect(),
    videoPosition = {
        left: videRect.left + document.documentElement.scrollLeft,
        top: videRect.top + document.documentElement.scrollTop
    },

    styles = window.getComputedStyle(video, null),

    videoDimensions = {
        width: parseInt(styles['width']),
        height: parseInt(styles['height'])
    }

var captureBtn = $('#capture-id')

captureBtn.addEventListener('click', function () {
    console.log('shot event fired')
    video.pause()
    var canvas = $('canvas'),
        context = canvas.getContext('2d')
    canvas.style.width = videoDimensions.width + 'px'
    canvas.style.height = videoDimensions.height + 'px'
    console.log(videoDimensions)
    console.log('canva: ' + canvas.style.width + ', ' + canvas.style.height)
    context.drawImage(video, 0, 0, videoDimensions.width, videoDimensions.height)
})


    