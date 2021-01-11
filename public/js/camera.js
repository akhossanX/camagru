'use strict';

const STICKER_WIDTH = 80;
const STICKER_HEIGHT = 80;
const STICKER_INIT_LEFT_OFFSET = '40%';
const STICKER_INIT_TOP_OFFSET = '40%';
const SAVE_IMAGE_URI = 'http://localhost:8080/images/get'
const PREVIEW_IMAGES_URI = 'http://localhost:8080/images/preview';
const DEVICE_PIXEL_RATIO = window.devicePixelRatio;


let $ = (selector) => document.querySelector(selector);

let stream_init = () => {
    if (navigator.mediaDevices.getUserMedia) {
        navigator.mediaDevices.getUserMedia(constraints)
        .then((stream) => {
            video.srcObject = stream;
            video.play();
            stickers.forEach(sticker => sticker.onclick = onStickerClickChooser);
            video.ondrop = onStickerDrop;
            video.ondragover = onStickerDragOver;
            video.style.zIndex = 0;
            uploadBtn.disabled = true;
        })
        .catch((error) => {
            video.style.display = 'none';
            console.log(error);
        });
    }
}

function onStickerClickChooser() {
    /* activate capture button */
    captureBtn.disabled = false;
    var img = document.createElement('img')
    img.style.position = 'absolute';
    img.style.left = STICKER_INIT_LEFT_OFFSET;
    img.style.top = STICKER_INIT_TOP_OFFSET;
    img.style.width = STICKER_WIDTH + 'px';
    img.style.height = STICKER_HEIGHT + 'px';
    img.src = this.src;
    img.ondblclick = onStickerDoubleClick;
    img.draggable = true;
    img.id = '_' + Math.random().toString(36);
    img.ondragstart = onStickerDragStart;
    img.ondragover = onStickerDragOver;
    img.ondrop = onStickerDrop;
    img.style.zIndex = ++zIndex;
    video.parentElement.appendChild(img);
}

function onStickerDoubleClick(event) {
    event.target.remove();
}

function onStickerDragStart(event) {
    event.dataTransfer.setData('text/plain', event.target.id);
} 

function onStickerDragOver(event) {
    event.preventDefault();
    event.dataTransfer.dropEffect = 'move';
}

function onStickerDrop(event) {
    event.preventDefault();
    var liveSticker = document.getElementById(event.dataTransfer.getData('text/plain'));
    if (liveSticker === null)
        return ;
    var mouseRelativePosition = {
        x: event.clientX + document.documentElement.scrollLeft - videoPosition.left,
        y: event.clientY + document.documentElement.scrollTop - videoPosition.top
    }
    var translationVector = {
        x: mouseRelativePosition.x - parseFloat(liveSticker.style.left),
        y: mouseRelativePosition.y - parseFloat(liveSticker.style.top)
    }
    var x = translationVector.x + parseFloat(liveSticker.style.left) - STICKER_WIDTH / 2.0,
        y = translationVector.y + parseFloat(liveSticker.style.top) - STICKER_HEIGHT / 2.0;
    liveSticker.style.left = x + 'px';
    liveSticker.style.top = y + 'px';
    liveSticker.style.zIndex = parseInt(event.target.style.zIndex) + 1;
}

function sendPictureDataToServer(data) {
    var xhr = new XMLHttpRequest(),
    url = new URL(SAVE_IMAGE_URI);
    xhr.onload = () => {
        // Here We have to update the list of captured images belonging to the user;
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
    arr = arr.filter(st => st.id !== 'uploaded-image');
    arr.forEach(img => {
        let obj = {};
        let str = new String(img.src).substring(img.src.lastIndexOf('/') + 1);
        obj.src = str;
        obj.x = img.offsetLeft * DEVICE_PIXEL_RATIO;
        obj.y = img.offsetTop * DEVICE_PIXEL_RATIO;
        obj.width = img.width * DEVICE_PIXEL_RATIO;
        obj.height = img.height * DEVICE_PIXEL_RATIO;
        obj.zIndex = parseInt(img.style.zIndex);
        stickers.push(obj);
    });
    // sort stickers according to their zindex;
    stickers.sort((a, b) => a.zIndex - b.zIndex);
    sendPictureDataToServer({stickers: stickers, image: imageURI});
    // Deactivate save button to prevent saving multiple copies of the same picture
    saveBtn.disabled = true;
}

function drawToPreviewCanvas() {
    var context = canvas.getContext('2d');
    canvas.style.maxWidth = '100%';
    canvas.style.maxHeight = '100%';
    canvas.width = target.offsetWidth * DEVICE_PIXEL_RATIO;
    canvas.height = target.offsetHeight * DEVICE_PIXEL_RATIO;
    context.drawImage(target, 0, 0, canvas.width, canvas.height);
    var st = document.querySelectorAll('#video-container-id img');
    st = [].slice.call(st).sort((a, b) => parseInt(a.style.zIndex) - parseInt(b.style.zIndex));
    for(var i = 0; i < st.length; i++) {
        var styles = window.getComputedStyle(st[i]);
        let left = parseFloat(styles['left']) * DEVICE_PIXEL_RATIO,
            top = parseFloat(styles['top']) * DEVICE_PIXEL_RATIO,
            width = parseFloat(st[i].style.width) * DEVICE_PIXEL_RATIO,
            height = parseFloat(st[i].style.height) * DEVICE_PIXEL_RATIO;
        context.drawImage(st[i], left, top, width, height);
    }
    canvas.style.display = 'block';
    saveBtn.style.display = 'block';
    saveBtn.disabled = false;
}

// can't be triggered until stickers are selected;
function capture() {
    let styles = window.getComputedStyle(target, null);
    hiddenCanvas.style.width = videoDimensions.width + 'px'
    hiddenCanvas.style.height = videoDimensions.height + 'px'
    hiddenCanvas.width = videoDimensions.width * DEVICE_PIXEL_RATIO;
    hiddenCanvas.height = videoDimensions.height * DEVICE_PIXEL_RATIO;
    let context = hiddenCanvas.getContext('2d');
    context.globalCompositionOperation = 'difference';
    if (target.hasOwnProperty('pause'))
        target.pause();
    context.drawImage(target, 0, 0, hiddenCanvas.width, hiddenCanvas.height);
    if (target.hasOwnProperty('play'))
        target.play();
    drawToPreviewCanvas();
}

function savePicture() {
    var imageURI = hiddenCanvas.toDataURL('image/png', 1.0).replace('data:image/png;base64,', '');
    assemblePicturesData(imageURI);
}

var video = $('#video-id'),
    target = video;
    zIndex = 0;

let styles = window.getComputedStyle(target, null);
let videoDimensions = {
        width: parseFloat(styles.getPropertyValue('width')),
        height: parseFloat(styles.getPropertyValue('height'))
    },
    constraints = {
        video: videoDimensions
    };

// Get all available stickers
let stickers = document.querySelectorAll('#stickers img');

// Init streaming camera device
stream_init();

var videoRect = target.getBoundingClientRect(),
    videoPosition = {
        left: videoRect.left + document.documentElement.scrollLeft,
        top: videoRect.top + document.documentElement.scrollTop
    }
var captureBtn = $('#capture-btn'),
    uploadBtn = $('#upload-btn'),
    saveBtn = $('#save-btn'),
    canvas = $('#preview-canvas'),
    hiddenCanvas = document.createElement('canvas');

// Deactivate saveBtn by default to prevent storing empty images
saveBtn.disabled = true;
saveBtn.onclick = savePicture;
saveBtn.style.display = 'none';
canvas.style.display = 'none';
captureBtn.onclick = capture;
captureBtn.disabled = true; // deactivated until sticker selection
var zIndex = 0;
var picList = $('#pictures-list')

uploadBtn.onclick = () => {
    var inputFile = document.createElement('input');
    inputFile.type = 'file';
    inputFile.name = 'upload';
    inputFile.accept = 'image/png, image/jpg';
    inputFile.click();
    inputFile.onchange = () => {
        var fr = new FileReader();
        var file = inputFile.files[0];
        fr.readAsDataURL(inputFile.files[0]);
        console.log(file);
        console.log(file.size);
        fr.onload = (event) => {
            if (file.size < 2e6) {
                let oldImage = document.getElementById('uploaded-image');
                if (oldImage !== null)
                    video.parentElement.removeChild(oldImage);
                stickers.forEach(sticker => sticker.onclick = onStickerClickChooser);// add click event on stickers
                const image = document.createElement('img');
                image.ondrop = onStickerDrop;
                image.ondragover = onStickerDragOver;
                image.id = 'uploaded-image';
                video.style.zIndex = 0;
                image.src = fr.result;
                image.style.maxWidth = '100%';
                image.style.maxHeight = '100%';
                image.style.position = 'relative';
                image.className += ' text-center';
                video.parentElement.appendChild(image);
                target = image;
                captureBtn.disabled = false;
            } else {
                alert('Large file');
            }
        }
    }
}