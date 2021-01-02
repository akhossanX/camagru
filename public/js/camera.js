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
    img.style.zIndex = zIndex++
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
}


function savePicture() {
    var dataUrl = canvas.toDataURL('image/png').replace("data:image/png;base64,", "")
    var pictures = document.querySelectorAll('#video-container-id img');
    var arr = [].slice.call(pictures);
    var st = [];
    arr.forEach(img => {
        let obj = {};
        let str = new String(img.src).substring(img.src.lastIndexOf('/') + 1);
        obj.src = str;
        obj.x = img.offsetLeft;
        obj.y = img.offsetTop;
        obj.width = img.width;
        obj.height = img.height;
        st.push(obj);
    });
    var cv = document.createElement('canvas');
    cv.width = videoDimensions.width;
    cv.height = videoDimensions.height;
    var ctx = cv.getContext('2d');
    ctx.drawImage(video, 0, 0, videoDimensions.width, videoDimensions.height)
    var im = cv.toDataURL('image/png', 1);
    sendPictureDataToServer(st, im);
    // Deactivate save button to prevent saving multiple copies of the same picture
    saveBtn.disabled = true
}

function sendPictureDataToServer(st, img) {
    var requestData = {
        stickers: st,
        image: img.replace("data:image/png;base64,", "")
    }
    var xhr = new XMLHttpRequest(),
        url = new URL(SAVE_IMAGE_URI);
        console.log(xhr);
        xhr.onload = () => {
            console.log(xhr.responseText);
        }
        xhr.onerror = (error) => {
            console.log(error);
        }
        requestData = JSON.stringify(requestData);
        xhr.open('POST', url, true);
        xhr.setRequestHeader('Content-Type', 'application/json; charset=UTF-8');
        xhr.send(requestData);
}

function capture() {
    var frames = 0;
    var dpi = window.devicePixelRatio;
    hiddenCanvas.style.width = videoDimensions.width + 'px'
    hiddenCanvas.style.height = videoDimensions.height + 'px'
    hiddenCanvas.width = videoDimensions.width;
    hiddenCanvas.height = videoDimensions.height;

    // hiddenCanvas.style.display = 'none';

    var context = hiddenCanvas.getContext('2d');
    context.globalCompositionOperation = 'difference';
    var id = setInterval(
        function () {
            context.drawImage(video, 0, 0, hiddenCanvas.width, hiddenCanvas.height)
            frames += 1
            if (frames >= 10) {
                clearInterval(id)
                var st = document.querySelectorAll('#video-container-id img')
                for (var i = st.length - 1; i >= 0; i--) {
                    context.drawImage(st[i], parseInt(st[i].style.left), parseInt(st[i].style.top),
                    parseInt(st[i].style.width), parseInt(st[i].style.height))
                }
            }
        },
        5 // 5 milliseconds between each capture
    )
    // Activate save button in live preview Canvas
    saveBtn.disabled = false;
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
    stickers = document.querySelectorAll('#stickers img')

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

var captureBtn = $('#capture-btn'),
    saveBtn = $('#save-btn'),
    canvas = $('#canvas'), 
    hiddenCanvas = document.createElement('canvas');

// Deactivate saveBtn by default to prevent storing empty images
saveBtn.disabled = true;

captureBtn.onclick = capture;
saveBtn.onclick = savePicture;

var picList = $('#pictures-list')

// console.log(picList)
// displayUserImages(picList)





    