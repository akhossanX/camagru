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
    console.log('Drag Start: ' + event.type)
    event.dataTransfer.setData('text/plain', this.id)
} 

function onStickerDragOver(event) {
    event.preventDefault()
    event.dataTransfer.dropEffect = 'move'
}

function onStickerDrop(event) {

    event.preventDefault()
    console.log('Drop Event: ')
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

    console.log(x + ', ' + y)
    if (x > videoDimensions.x - 50) {
        console.log('x >')
        x = x - videoDimensions.x + 50
    }
    if (x < videoDimensions.x) {
        console.log('x <')
        x = videoDimensions.x - 50 - x
    }
    if (y > videoDimensions.y - 50) {
        console.log('y >')
        y = y - videoDimensions.y + 50
    }
    if (x < videoDimensions.y - 50) {
        console.log('y <')
        y = videoDimensions.y - 50 - x
    }

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

console.log(videoPosition)
console.log(videoDimensions)


    