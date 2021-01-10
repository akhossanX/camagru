'use strict';

let checkForArrayNameInput = (inputs) => {
    let success = true;
    inputs.forEach(input => {
        let re = /.*\[.*\]$/g;
        if (re.test(input.name) === true) {
            let errorSpan = document.querySelector(".form-group span#" + input.id);
            errorSpan.textContent = "Array input detected in field name: " + input.name;
            success = false;
        }
    });
    return success;
}

let checkEmail = function () {
    let email = this.value;
    let oldColor = this.style.borderColor;
    let span = document.querySelector('.form-group span#' + this.id);
    let re = /^\w+\.?\w+@\w+\.[a-z]{2,3}$/;
    if (re.test(email) === false) {
        this.style.borderColor = 'red';
        span.innerHTML = 'error in mail';
    } else {
        span.innerHTML = '';
        this.style.borderColor = oldColor;
    }
}

let checkPassword = function () {
    if (this.id === 'confirm-password')
        return ;
    let password = this.value;
    let oldColor = this.style.borderColor;
    let span = document.querySelector('.form-group span#' + this.id);
    // console.log(span);
    let re = /\w+|_/;
    if (re.test(password) === false) {
        span.innerHTML = 'password should contain lower uper letters and digits';
        this.style.borderColor = 'red';
        return ;
    }
    if (password.length < 8) {
        span.innerHTML = 'password should be minimum 8 characters';
        this.style.borderColor = 'red';
        return ;
    }
    span.innerHTML = '';
    this.style.borderColor = oldColor;
}

let form = document.getElementsByClassName("auth-form");

if (form !== null) {
    [].forEach.call(form, (form) => {
        form.noValidate = true;
        let inputs = document.querySelectorAll(".form-group input");
        inputs.forEach(input => {
            switch (input.type) {
                case 'email': input.oninput = checkEmail; break;
                case 'password': input.oninput = checkPassword; break;
                default : break;
            }
        });
        form.onsubmit = (event) => {
            event.preventDefault();
            if (checkForArrayNameInput(inputs) === true) {
                form.submit();
            }
        };
    });
}