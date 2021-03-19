'use strict';

const STICKER_WIDTH = 80;
const STICKER_HEIGHT = 80;
const STICKER_INIT_LEFT_OFFSET = '40%';
const STICKER_INIT_TOP_OFFSET = '40%';
const SAVE_IMAGE_URI = 'http://localhost:8080/images/get'
const PREVIEW_IMAGES_URI = 'http://localhost:8080/images/preview';
const DEVICE_PIXEL_RATIO = window.devicePixelRatio;
const WIDTH = 640;
const HEIGHT = 480;

var $ = (selector) => document.querySelector(selector),
    video = $('#video-id'),
    target = video,
    zIndex = 0,
    streaming = false,
    videoDimensions = {
        width: WIDTH,     //video.offsetWidth,
        height: HEIGHT    //video.offsetHeight
    },
    constraints = {video: true, audio: false},
// Get all available stickers
    stickers = document.querySelectorAll('#stickers img'),
    selected = null;
// Init streaming camera device
stream_init();
var videoRect = target.getBoundingClientRect(),
    videoPosition = {
        left: videoRect.left + document.documentElement.scrollLeft,
        top: videoRect.top + document.documentElement.scrollTop
    },
    captureBtn = $('#capture-btn'),
    uploadBtn = $('#upload-btn'),
    saveBtn = $('#save-btn'),
    canvas = $('#preview-canvas');
// Deactivate saveBtn by default to prevent storing empty images
saveBtn.disabled = true;
saveBtn.onclick = savePicture;
saveBtn.style.display = 'none';
canvas.style.display = 'none';
captureBtn.onclick = capture;
captureBtn.disabled = true; // deactivated until sticker selection
var picList = $('#pictures-list');

window.onresize = () => {
    videoRect = target.getBoundingClientRect();
    videoPosition = {
        left: videoRect.left + document.documentElement.scrollLeft,
        top: videoRect.top + document.documentElement.scrollTop
    };
};
function checkMediaDevices() {
    if (navigator.mediaDevices === undefined) {
        navigator.mediaDevices = {};
    }
    if (navigator.mediaDevices.getUserMedia === undefined) {
        navigator.mediaDevices.getUserMedia = function(constraints) {
          // First get a hold of the legacy getUserMedia, if present
          var getUserMedia = navigator.webkitGetUserMedia || navigator.mozGetUserMedia;
          // Some browsers just don't implement it - return a rejected promise with an error
          // to keep a consistent interface
          if (!getUserMedia) {
            return Promise.reject(new Error('getUserMedia is not available in this browser'));
          }
          // Otherwise, wrap the call to the old navigator.getUserMedia with a Promise
          return new Promise(function(resolve, reject) {
            getUserMedia.call(navigator, constraints, resolve, reject);
          });
        }
    }
}

function stream_init () {
    checkMediaDevices();
    navigator.mediaDevices.getUserMedia(constraints)
    .then( stream => {
        video.srcObject = stream;
        video.play();
        stickers.map(sticker => sticker.onclick = onStickerClickChooser);
        video.ondrop = onStickerDrop;
        video.ondragover = onStickerDragOver;
        video.style.zIndex = 0;
    })
    .catch((error) => {
        console.log(error.message);
    });
};

function onStickerClickChooser() {
    /* activate capture button */
    captureBtn.disabled = false;
    if (video.parentElement.hasChildNodes()) {
        var img = document.createElement('img');
        img.style.position = 'absolute';
        img.style.left = STICKER_INIT_LEFT_OFFSET;
        img.style.top = STICKER_INIT_TOP_OFFSET;
        img.style.width = '20%';//STICKER_WIDTH + 'px';
        img.style.height = '20%';//STICKER_HEIGHT + 'px';
        img.src = this.src;
        img.ondblclick = onStickerDoubleClick;
        img.draggable = true;
        img.id = '_' + Math.random().toString(36);
        img.ondragstart = onStickerDragStart;
        img.ondragover = onStickerDragOver;
        img.ondrop = onStickerDrop;
        img.classList.add("live-sticker");
        img.onclick = function () {
            selected = img;
            if (selected.style.border === 'none')
                selected.style.border = '1px solid orange';
            else
                selected.style.border = 'none';
        }
        img.style.zIndex = ++zIndex;
        video.parentElement.appendChild(img);
    }
}


function onStickerDoubleClick(event) {
    event.target.remove();
    const container = document.querySelector("#video-container-id");
    // if video element isn't active then we have two childs: video element, and uploaded image
    // otherwise we have only video element
    const number = (target === video) ? 1 : 2; 
    if (container.children.length <= number) {
        captureBtn.disabled = true;
    }
}

function onStickerDragStart(event) {
    event.dataTransfer.setData('text/plain', event.target.id);
    // event.target.style.border = "1px solid blue";
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
    };
    var translationVector = {
        x: mouseRelativePosition.x - parseInt(liveSticker.style.left),
        y: mouseRelativePosition.y - parseInt(liveSticker.style.top)
    }
    var x = translationVector.x + parseInt(liveSticker.style.left) - STICKER_WIDTH / 2,
        y = translationVector.y + parseInt(liveSticker.style.top) - STICKER_HEIGHT / 2;
    var bottomRightCorner = {x: x + liveSticker.offsetWidth, y: y + liveSticker.offsetHeight};
    var topLeftCorner = {x, y};
    if (
        topLeftCorner.x >= 0 && topLeftCorner.y >= 0
        && bottomRightCorner.x <= target.offsetWidth && bottomRightCorner.y <= target.offsetHeight
    ) {
        liveSticker.style.left = x + 'px';
        liveSticker.style.top = y + 'px';
        liveSticker.style.zIndex = parseInt(event.target.style.zIndex) + 1;
    }
}


function sendPictureDataToServer(data) {
    var xhr = new XMLHttpRequest(),
    url = new URL(SAVE_IMAGE_URI);
    xhr.onload = () => {
        // We update the list of captured images belonging to the user
        var imgArea = document.querySelector(".user-images-area");
        var response = JSON.parse(xhr.response);
        var component = creatImageComponent(response);
        imgArea.prepend(component);
    }
    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-Type', 'application/json; charset=UTF-8');
    xhr.send(JSON.stringify(data));
}

function assemblePicturesData(imageURI) {
    var previewContainer = document.querySelector("#preview-container-id")
    var pictures = document.querySelectorAll('#preview-container-id img');
    var arr = [].slice.call(pictures);
    var stickers = [];
    for (var i = 0; i < arr.length; i++) {
        var obj = {};
        var str = new String(arr[i].src).substring(arr[i].src.lastIndexOf('/') + 1);
        obj.src = str;
        obj.x = arr[i].offsetLeft * DEVICE_PIXEL_RATIO;
        obj.y = arr[i].offsetTop * DEVICE_PIXEL_RATIO;
        obj.width = arr[i].width * DEVICE_PIXEL_RATIO;
        obj.height = arr[i].height * DEVICE_PIXEL_RATIO;
        obj.zIndex = parseInt(arr[i].style.zIndex);
        stickers.push(obj);
        previewContainer.removeChild(arr[i]);
    }
    // sort stickers according to their zindex;
    stickers.sort((a, b) => a.zIndex - b.zIndex);
    sendPictureDataToServer({stickers: stickers, image: imageURI});
    // Deactivate save button to prevent saving multiple copies of the same picture
    saveBtn.disabled = true;
}

function drawToPreviewCanvas() {
    var context = canvas.getContext('2d');
    canvas.width = videoRect.width;//video.width;//'100%';
    canvas.height = videoRect.height;//video.height;//'100%';
    // canvas.style.width = videoRect.width + 'px';
    // canvas.style.height = videoRect.height + 'px';
    canvas.width = target.offsetWidth * DEVICE_PIXEL_RATIO;
    canvas.height = target.offsetHeight * DEVICE_PIXEL_RATIO;
    if (target.hasOwnProperty('pause'))
        target.pause();
    context.drawImage(target, 0, 0, canvas.width, canvas.height);
    if (target.hasOwnProperty('play'))
        target.play();
    var st = document.querySelectorAll('#video-container-id img.live-sticker');
    if (st.length !== 0) {
        st = [].slice.call(st).sort((a, b) => parseInt(a.style.zIndex) - parseInt(b.style.zIndex));
    } else {
        return false;
    }
    for(var i = 0; i < st.length; i++) {
        var styles = window.getComputedStyle(st[i]);
        var left = parseFloat(styles['left']) * DEVICE_PIXEL_RATIO,
            top = parseFloat(styles['top']) * DEVICE_PIXEL_RATIO,
            width = parseFloat(st[i].style.width) * DEVICE_PIXEL_RATIO,
            height = parseFloat(st[i].style.height) * DEVICE_PIXEL_RATIO;
        st[i].ondblclick = null;
        st[i].onclick = null;
        st[i].ondragover = null;
        st[i].ondrop = null;
        st[i].style.border = 'none';
        canvas.parentElement.appendChild(st[i]);
    }
    target.style.display = 'none';
    video.style.display = 'block';
    canvas.style.display = 'block';
    saveBtn.style.display = 'block';
    saveBtn.disabled = false;
}

// can't be triggered until stickers are selected;
function capture() {
    while (canvas.nextElementSibling) {
        canvas.nextElementSibling.remove();
    }
    drawToPreviewCanvas();
    target = video;
    captureBtn.disabled = true;
}

function savePicture() {
    var imageURI = canvas.toDataURL('image/png', 1.0).replace('data:image/png;base64,', '');
    assemblePicturesData(imageURI);
}

video.addEventListener('canplay', event => {
    if (streaming === false) {
        streaming = true;
    }
}, false);

uploadBtn.onclick = () => {
    var inputFile = document.createElement('input');
    inputFile.type = 'file';
    inputFile.name = 'upload';
    inputFile.accept = 'image/png, image/jpg, image/jpeg';
    inputFile.click();
    inputFile.onchange = () => {
        var fr = new FileReader();
        var file = inputFile.files[0];
        fr.readAsDataURL(inputFile.files[0]);
        fr.onload = (event) => {
            if (file.size < 2e6 && file.size > 0) {
                var oldImage = document.getElementById('uploaded-image');
                if (oldImage !== null)
                    video.parentElement.removeChild(oldImage);
                stickers.forEach(sticker => sticker.onclick = onStickerClickChooser);
                const image = document.createElement("img");
                image.src = fr.result;
                image.onload = function () {
                    if (this.width) {
                        image.ondrop = onStickerDrop;
                        image.ondragover = onStickerDragOver;
                        image.id = 'uploaded-image';
                        video.style.zIndex = 0;
                        image.style.width = "100%";
                        image.style.maxHeight = "480px";
                        image.style.position = 'relative';
                        image.className += ' text-center';
                        video.style.display = 'none';
                        video.parentElement.appendChild(image);
                        target = image;
                        captureBtn.disabled = true;
                    } else {
                        alert('invalid image file');
                    }
                }
                
            } else {
                alert('Invalid file');
            }
        }
    }
}

var slider = document.querySelector('.container.size-slider #range');
slider.oninput = function resize() {
    if (selected != null && selected.style.border !== 'none') {
        selected.style.width = this.value + 'px';
        selected.style.height = this.value + 'px';
    }
}

var deleteBtns = document.querySelectorAll("#delete-btn");
deleteBtns.forEach( btn => btn.addEventListener('click', deleteImage));

function deleteImage(event) {
    const parent = event.target.parentElement.parentElement;
    const target = parent.querySelector("img");
    const xhr = new XMLHttpRequest();
    const url = new URL(DELETE_IMAGE_URL);
    xhr.open('POST', url, true);
    xhr.setRequestHeader("content-type", "application/json");
    const id = target.id;
    xhr.send(`{"imageid": ${id}}`);
    xhr.onload = () => {
        const response = JSON.parse(xhr.response);
        if ('state' in response && response.state === true) {
            const usrImagesArea = document.querySelector(".user-images-area");
            usrImagesArea.removeChild(parent);
        }
    }
}

function creatImageComponent(response) {
    const container = document.createElement("div");
    container.classList.add("usr-image-container");
    const img = document.createElement('img');
    img.src = "data:image/png;base64, " + response.data;
    img.classList.add("usr-img-preview", "img-thumbnail");
    img.id = response.id;
    const btnContainer = document.createElement("div");
    btnContainer.classList.add("delete-btn-container");
    const icon = document.createElement("i");
    icon.classList.add("btn", "fas", "fa-trash");
    icon.id = "delete-btn";
    icon.onclick = deleteImage;
    btnContainer.appendChild(icon);
    container.appendChild(img);
    container.appendChild(btnContainer);
    return container;
}