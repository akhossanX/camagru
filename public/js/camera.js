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

function drawToCanvas(stream, streamDimensions) {
    var cv = document.createElement('canvas');
    cv.width = streamDimensions.width;
    cv.height = streamDimensions.height;
    var ctx = cv.getContext('2d');
    ctx.drawImage(stream, 0, 0, streamDimensions.width, streamDimensions.height)
    return cv.toDataURL('image/png', 1);
}

function assemblePicturesData() {
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
    let im = drawToCanvas(video, videoDimensions);
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
            let image = new Image();
            image.src = 'data:image/png;base64, ' + xhr.responseText;
            drawToCanvas(image, {width: image.width, height: image.height})
            var previewArea = $('#preview-area').style.display = 'block';
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
    // var dpi = window.devicePixelRatio;
    // console.log(dpi)
    // canvas.style.width = videoDimensions.width + 'px'
    // canvas.style.height = videoDimensions.height + 'px'
    canvas.width = videoDimensions.width;
    canvas.height = videoDimensions.height;

    var context = canvas.getContext('2d');
    context.globalCompositionOperation = 'difference';
    var id = setInterval(
        function () {
            context.drawImage(video, 0, 0, canvas.width, canvas.height);
            frames += 1
            if (frames >= 10) {
                clearInterval(id)
                // var st = document.querySelectorAll('#video-container-id img')
                // for (var i = st.length - 1; i >= 0; i--) {
                //     context.drawImage(st[i], parseInt(st[i].style.left), parseInt(st[i].style.top),
                //     parseInt(st[i].style.width), parseInt(st[i].style.height))
                // }
            }
        },
        5 // 5 milliseconds between each capture
    )
    // Activate save button in live preview Canvas
    saveBtn.disabled = false;
    assemblePicturesData();
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
    canvas = $('#canvas'), 
    hiddenCanvas = document.createElement('canvas');

// Deactivate saveBtn by default to prevent storing empty images
saveBtn.disabled = true;

captureBtn.onclick = capture;
// saveBtn.onclick = savePicture;

var picList = $('#pictures-list')







    