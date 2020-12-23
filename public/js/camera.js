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
    img.draggable = true
    img.id = '_' + Math.random().toString(36)
    img.ondragstart = onStickerDragStart
    video.insertAdjacentElement('afterEnd', img)
}

function OnStickerDoubleClick() {
    this.remove()
}

function onStickerDragStart(event) {
    console.log('Drag Start: ' + event.type)
    console.log(this.id)
    event.dataTransfer.setData('text/plain', this.id)
} 

function onStickerDragOver(event) {
    event.preventDefault()
    event.dataTransfer.dropEffect = 'move'
}

function onStickerDrop(event) {
    console.log('Drop Event: ' + event.type)
    var liveSticker = document.getElementById(event.dataTransfer.getData('text/plain'))
    console.log('video position: (' + videoPosition.left + ', ' + videoPosition.top + ')')
    console.log('mouse absolute position: (' + event.clientX + ', ' + event.clientY + ')')
    var translationVector = {
        x: event.clientX - videoPosition.left,
        y: event.clientY - videoPosition.top
    }
    console.log(translationVector)
    console.log('mouse relatvie position: ' + parseInt(event.clientX + translationVector.x) + ', '
        + parseInt(event.clientY + translationVector.y))
    console.log('element new position: ' + 
                liveSticker.style.left + translationVector.x + ', ' + 
                liveSticker.style.top + translationVector.y)
    liveSticker.style.left = parseInt(liveSticker.style.left) +  translationVector.x + 'px'
    liveSticker.style.top = parseInt(liveSticker.style.top) + translationVector.y + 'px'
}

var video = $('#video-id'),
    videoContainer = document.getElementById('video-container-id')

var styles = window.getComputedStyle(videoContainer, null)
var width = parseInt(styles.getPropertyValue('width'))
var height = parseInt(styles.getPropertyValue('height'))

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

video.ondrop = onStickerDrop
video.ondragover = onStickerDragOver

var videRect = video.getBoundingClientRect()
var videoPosition = {
    left: videRect.left + document.documentElement.scrollLeft,
    top: videRect.top + document.documentElement.scrollTop
}

console.log('vide pos: ' + videoPosition.left + ', ', + videoPosition.top)


    