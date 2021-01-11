'use strict';

let checkForArrayNameInput = (inputs) => {
    let success = true;
    inputs.forEach(input => {
        let re = /.*\[.*\]$/;
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
    let re = /^(?!\d.*)(?![._])(?!.*\s)[\w.]+(?<![_.]+)@(?![._]+)[\w.]+(?<![._])\.([a-zA-Z]{2,3})$/;
    if (re.test(email) === false) {
        this.className += ' input-error';
        span.innerHTML = 'Invalid email';
    } else {
        if (this.classList.contains("input-error"))
            this.classList.toggle("input-error");
        span.innerHTML = '';
    }
}

let checkPassword = function () {
    if (this.id === 'confirm-password') {
        let password = document.querySelector('.form-group input[id=password]');
        let span = document.querySelector('.form-group span#' + this.id);
        password = password.value;
        if (this.value !== password) {
            this.className += ' input-error';
            span.innerHTML = `Passwords does not match`;
        } else {
            if (this.classList.contains("input-error"))
                this.classList.toggle("input-error");
            span.innerHTML = ``;
        }
        return ;
    }
    let password = this.value;
    let oldColor = this.style.borderColor;
    let span = document.querySelector('.form-group span#' + this.id);
    let re = /^(?=\S{8,20}$)(?=.*\d+.*)(?=.*[a-zA-Z_]+.*)(?=.*[!@#$%^&*()].*)/;
    if (re.test(password) === false) {
        span.innerHTML = `Must contain at least a-zA-Z0-9 and
         at least one of '!@#$%^&*()' and 8 up to 20 characters`;
        this.className += ' input-error';
        return ;
    }
    if (password.length < 8) {
        span.innerHTML = 'Must have minimum of 8 characters';
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
    let re = /^(?=.{8,20}$)(?![._])(?!.*[._]{2})[\w.]+(?<![_.])$/;
    if (re.test(username) === false) {
        span.innerHTML = 'Must contain 8 up to 20 english characters or digits or _.';
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
        console.log('onsubmit');
        event.preventDefault();
        inputs.forEach(input => {
            if (input.value === "") {
                let span = document.querySelector(".form-group span#" + input.id);
                span.innerHTML = "Please fill in the field";
                input.className += ' input-error';
            }
        });
        if (checkForArrayNameInput(inputs) === true) {
            console.log('submitted');
            let submitter = document.createElement("input");
            submitter.type = 'hidden';
            submitter.name = 'register';
            submitter.value = 'register';
            this.appendChild(submitter);
            this.submit();
        } else {
            console.log('not submitted');
        }
    }
}