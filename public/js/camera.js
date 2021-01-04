'use strict';

const STICKER_WIDTH = 70
const STICKER_HEIGHT = 80
const STICKER_INIT_LEFT_OFFSET = '40%'
const STICKER_INIT_TOP_OFFSET = '40%'
const SAVE_IMAGE_URI = 'http://localhost:8080/images/save'
const PREVIEW_IMAGES_URI = 'http://localhost:8080/images/preview'


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
            alert(error)
        })
    }
}

function onStickerClickChooser() {
    //activate capture button
    captureBtn.disabled = false;
    var img = document.createElement('img')
    img.style.position = 'absolute';
    img.style.left = STICKER_INIT_LEFT_OFFSET
    img.style.top = STICKER_INIT_TOP_OFFSET
    img.style.width = STICKER_WIDTH + 'px'
    img.style.height = STICKER_HEIGHT + 'px'
    img.src = this.src
    img.ondblclick = onStickerDoubleClick
    img.draggable = true
    img.id = '_' + Math.random().toString(36)
    img.ondragstart = onStickerDragStart
    img.ondragover = onStickerDragOver
    img.ondrop = onStickerDrop
    img.style.zIndex = zIndex++;
    video.insertAdjacentElement('afterEnd', img)
}

function onStickerDoubleClick() {
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
    var x = translationVector.x + parseInt(liveSticker.style.left) - STICKER_WIDTH / 2,
        y = translationVector.y + parseInt(liveSticker.style.top) - STICKER_HEIGHT / 2
    liveSticker.style.left = x + 'px'
    liveSticker.style.top = y + 'px'
    console.log(event.target);
    liveSticker.style.zIndex = parseInt(event.target.style.zIndex) + 1;
}

function sendPictureDataToServer(data) {
    var xhr = new XMLHttpRequest(),
    url = new URL(SAVE_IMAGE_URI);
    xhr.onload = () => {
        console.log(xhr.responseText);
    }
    xhr.onerror = (error) => {
        console.log(error);
    }
    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-Type', 'application/json; charset=UTF-8');
    xhr.send(JSON.stringify(data));
}

function assemblePicturesData(imageURI) {
    var pictures = document.querySelectorAll('#video-container-id img');
    var arr = [].slice.call(pictures);
    var stickers = [];
    arr.forEach(img => {
        let obj = {};
        let str = new String(img.src).substring(img.src.lastIndexOf('/') + 1);
        obj.src = str;
        obj.x = img.offsetLeft;
        obj.y = img.offsetTop;
        obj.width = img.width;
        obj.height = img.height;
        obj.zIndex = parseInt(img.style.zIndex);
        stickers.push(obj);
    });
    // sort stickers according to their zindex;
    stickers.sort((a, b) => a.zIndex - b.zIndex);
    console.log(stickers);
    sendPictureDataToServer({stickers: stickers, image: imageURI});
    // Deactivate save button to prevent saving multiple copies of the same picture
    saveBtn.disabled = true
}

function drawToPreviewCanvas() {
    var context = canvas.getContext('2d');
    canvas.style.width = videoDimensions.width + 'px';
    canvas.style.height = videoDimensions.height + 'px';
    canvas.width = videoDimensions.width;
    canvas.height = videoDimensions.height;
    context.drawImage(video, 0, 0, videoDimensions.width, videoDimensions.height);
    var st = document.querySelectorAll('#video-container-id img');
    console.log(st);
    st = [].slice.call(st).sort((a, b) => parseInt(a.style.zIndex) - parseInt(b.style.zIndex));
    for(var i = 0; i < st.length; i++) {
        context.drawImage(st[i], parseInt(st[i].style.left), parseInt(st[i].style.top),
        parseInt(st[i].style.width), parseInt(st[i].style.height));
    }
    var previewArea = $('#preview-area').style.display = 'block';
    saveBtn.disabled = false;
}

// can't be triggered until stickers are selected;
function capture() {
    var frames = 0;
    hiddenCanvas.style.width = videoDimensions.width + 'px'
    hiddenCanvas.style.height = videoDimensions.height + 'px'
    hiddenCanvas.width = videoDimensions.width;
    hiddenCanvas.height = videoDimensions.height;
    let context = hiddenCanvas.getContext('2d');
    context.globalCompositionOperation = 'difference';
    video.pause();
    context.drawImage(video, 0, 0, hiddenCanvas.width, hiddenCanvas.height);
    video.play();
    drawToPreviewCanvas();
}

function savePicture() {
    var imageURI = hiddenCanvas.toDataURL('image/png', 1.0).replace('data:image/png;base64,', '');
    assemblePicturesData(imageURI);
}

var video = $('#video-id'),
    zIndex = 0,
    styles = window.getComputedStyle(video, null),
    videoDimensions = {
        width: parseInt(styles.getPropertyValue('width')),
        height: parseInt(styles.getPropertyValue('height'))
    },
    // 8 is the double of the video element's border size
    constraints = {
        video: videoDimensions
    },
    stickers = document.querySelectorAll('#stickers img')
    console.log('video dimensions');
    console.log(videoDimensions)

stream_init()

stickers.forEach(sticker => sticker.onclick = onStickerClickChooser)
video.ondrop = onStickerDrop
video.ondragover = onStickerDragOver

var videRect = video.getBoundingClientRect(),
    videoPosition = {
        left: videRect.left + document.documentElement.scrollLeft,
        top: videRect.top + document.documentElement.scrollTop
    }
var captureBtn = $('#capture-btn'),
    saveBtn = $('#save-btn'),
    canvas = $('#preview-canvas'),
    hiddenCanvas = document.createElement('canvas');

// Deactivate saveBtn by default to prevent storing empty images
saveBtn.disabled = true;

captureBtn.onclick = capture;
captureBtn.disabled = true; // deactivated until sticker selection
saveBtn.onclick = savePicture;
video.style.zIndex = 0;
var zIndex = 0;

var picList = $('#pictures-list')







    