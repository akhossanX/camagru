'use strict';

function $(selector) {
    return document.querySelector(selector)
}

var video = $('#video')

// console.log(video)
if (navigator.mediaDevices.getUserMedia) {
    navigator.mediaDevices.getUserMedia({video: true})
    .then(function (stream) {
        video.srcObject = stream
        video.play()
    })
    .catch(function (error){
        console.log(error)
        alert(error)
    });
}