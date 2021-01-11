'use strict';

let checkForArrayNameInput = (inputs) => {
    let success = true;
    inputs.forEach(input => {
        let re = /.*\[.*\]$/g;
        if (re.test(input.name) === true) {
            let errorSpan = document.querySelector(".form-group span#" + input.id);
            errorSpan.innerHTML = "Array input detected in field name: " + input.name;
            success = false;
        }
    });
    return success;
}

let checkEmail = function () {
    let email = this.value;
    let span = document.querySelector('.form-group span#' + this.id);
    let re = /^\w+\.?\w+@\w+\.[a-z]{2,3}$/;
    if (re.test(email) === false) {
        this.className += ' input-error';
        span.innerHTML = 'Please enter a valid email';
    } else {
        if (this.classList.contains("input-error"))
            this.classList.toggle("input-error");
        span.innerHTML = '';
    }
}

let checkPassword = function () {
    if (this.id === 'confirm-password')
        return ;
    let password = this.value;
    let oldColor = this.style.borderColor;
    let span = document.querySelector('.form-group span#' + this.id);
    let re = /\w+|_/;
    if (re.test(password) === false) {
        span.innerHTML = 'password should contain lower uper letters and digits';
        this.className += ' input-error';
        return ;
    }
    if (password.length < 8) {
        span.innerHTML = 'password should be minimum 8 characters';
        this.className += ' input-error';
        return ;
    }
    span.innerHTML = '';
    if (this.classList.contains("input-error"))
        this.classList.toggle("input-error");
}

let checkUserName = function () {
    let username = this.value;
    let span = document.querySelector('.form-group span#' + this.id);
    let re = /^((\w+)|(\d+)){8}$/;
    if (re.test(username) === false) {
        span.innerHTML = 'invalid username';
        this.className += ' input-error';
    } else {
        if (this.classList.contains("input-error"))
            this.classList.toggle("input-error");
        span.innerHTML = '';
    }
}

let form = document.getElementsByClassName("auth-form");
// console.log(form);  

if (form.length !== 0) {
    form = form[0];
    form.noValidate = true;
    let inputs = document.querySelectorAll(".form-group input");

    inputs.forEach(input => {
        input.required = true;
        switch (input.type) {
            case 'email': input.oninput = checkEmail; break;
            case 'password': input.oninput = checkPassword; break;
            case 'text' : input.oninput = checkUserName; break;
            default : break;
        }
    });

    form.onsubmit = function (event) {
        console.log('onsubmit')
        event.preventDefault();
        inputs.forEach(input => {
            if (input.value === "") {
                console.log(input.id);
                let span = document.querySelector(".form-group span#" + input.id);
                console.log(span);
                span.innerHTML = "Please fill in thie field";
                input.className += ' input-error';
            }
        });
        if (checkForArrayNameInput(inputs) === true) {
            console.log('submitted')
            // this.submit();
        } else {
            console.log('not submitted')
        }
    }
}