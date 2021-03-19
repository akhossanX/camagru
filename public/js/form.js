'use strict';

var valid = true;

var checkForArrayNameInput = (inputs) => {
    var success = true;
    inputs.forEach(input => {
        var re = /.*\[.*\]$/;
        if (re.test(input.name) === true) {
            var errorSpan = document.querySelector(".form-group span#" + input.id);
            errorSpan.innerHTML = "Array input detected in field name: " + input.name;
            success = false;
        }
    });
    return success;
}

var checkEmail = function () {
    var email = this.value;
    var span = document.querySelector('.form-group span#' + this.id);
    var re = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)+$/;
    if (re.test(email) === false) {
        this.className += ' input-error';
        span.innerHTML = 'Invalid email';
        valid = false;
    } else {
        if (this.classList.contains("input-error"))
            this.classList.toggle("input-error");
        span.innerHTML = '';
        valid = true;
    }
}

var checkPassword = function () {
    if (this.id === 'confirm-password') {
        var password = document.querySelector('.form-group input[id=password]');
        var span = document.querySelector('.form-group span#' + this.id);
        password = password.value;
        if (this.value !== password) {
            this.className += ' input-error';
            span.innerHTML = `Passwords do not match`;
            valid = false;
        } else {
            if (this.classList.contains("input-error"))
                this.classList.toggle("input-error");
            span.innerHTML = ``;
            valid = true;
        }
        return ;
    }
    var password = this.value;
    var oldColor = this.style.borderColor;
    var span = document.querySelector('.form-group span#' + this.id);
    var re = /^(?=\S{8,20}$)(?=.*\d+.*)(?=.*[a-z_]+.*)+(?=.*[A-Z].*)+(?=.*[!@#$%^&*()]+.*)/;
    if (re.test(password) === false) {
        span.innerHTML = `Must contain at least a-zA-Z0-9 and
         at least one of '!@#$%^&*()' and 8 up to 20 characters`;
        this.className += ' input-error';
        valid = false;
        return ;
    }
    if (password.length < 8) {
        span.innerHTML = 'Must have minimum of 8 characters';
        this.className += ' input-error';
        valid = false;
        return ;
    }
    span.innerHTML = '';
    valid = true;
    if (this.classList.contains("input-error"))
        this.classList.toggle("input-error");
}

var checkUserName = function () {
    var username = this.value;
    var span = document.querySelector('.form-group span#' + this.id);
    var re = /^(?=.{8,20}$)(?![._])(?!.*[._]{2})[\w.]+(?![_.]$)$/;
    if (re.test(username) === false) {
        span.innerHTML = 'Must contain 8 up to 20 english characters or digits or _.';
        this.className += ' input-error';
        valid = false;
    } else {
        if (this.classList.contains("input-error"))
            this.classList.toggle("input-error");
        span.innerHTML = '';
        valid = true;
    }
}

var form = document.getElementsByClassName("auth-form");

if (form.length !== 0) {
    form = form[0];
    form.noValidate = true;
    var inputs = document.querySelectorAll(".form-group input");

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
        event.preventDefault();
        inputs.forEach(input => {
            if (input.value === "") {
                var span = document.querySelector(".form-group span#" + input.id);
                span.innerHTML = "Please fill in the field";
                input.className += ' input-error';
                valid = false;
            }
        });
        if (checkForArrayNameInput(inputs) === true && valid === true) {
            var submitter = document.createElement("input");
            submitter.type = 'hidden';
            submitter.name = event.submitter.name;
            submitter.value = event.submitter.name;
            this.appendChild(submitter);
            this.submit();
        }
    }
}

