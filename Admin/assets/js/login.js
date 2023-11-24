// Animations
const registerButton = document.getElementById("register");
const loginButton = document.getElementById("login");
const container = document.getElementById("container");

registerButton.addEventListener("click", () => {
  container.classList.add("right-panel-active");
});

loginButton.addEventListener("click", () => {
  container.classList.remove("right-panel-active");
});

// Check Register Error
const form = document.querySelector('.form')
const username = document.querySelector('#username')
const usernameError = document.querySelector("#username-error")
const email = document.querySelector('#email')
const emailError = document.querySelector("#email-error")
const password = document.querySelector('#password')
const passwordError = document.querySelector("#password-error")

// Show input error message
function showError(input, message) {
    const formControl = input.parentElement
    formControl.className = 'form-control1 error'
    const small = formControl.querySelector('small')
    small.innerText = message
}

// Show success outline
function showSuccess(input) {
    const formControl = input.parentElement
    formControl.className = 'form-control1 success'
    const small = formControl.querySelector('small')
    small.innerText = ''
}

// Check email is valid
function checkEmailValidity(emailInput) {
    const emailRegex = /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/;
    return emailRegex.test(emailInput.value);
}

email.addEventListener("input", function() {
    if (!checkEmailValidity(email)) {
        emailError.textContent = "*Email không có hiệu lực.";
    } else {
        emailError.textContent = "";
    }
});

// Check length input user name
username.addEventListener("input", function(){
    if (username.value.length < 4) {
        usernameError.textContent = "*Tài khoản phải có ít nhất 4 kí tự."
    }else if(username.value.length > 20){
        usernameError.textContent = "*Tài khoản không được dài hơn 20 kí tự.";
    }else {
        usernameError.textContent = "";
    }
})

// Check length input password
password.addEventListener("input", function(){
    if (password.value.length < 4) {
        passwordError.textContent = "*Mật khẩu phải có ít nhất 4 kí tự."
    }else if(password.value.length > 20){
        passwordError.textContent = "*Mật khẩu không được dài hơn 20 kí tự."
    }else {
        passwordError.textContent = "";
    }
})


// Check required fields
function checkRequired(inputArr) {
    let isRequired = false
    inputArr.forEach(function(input) {
        if (input.value.trim() === '') {
            showError(input, `*${getFieldName(input)} bắt buộc phải có!`)
            isRequired = true
        }else {
            showSuccess(input)
        }
    })

    return isRequired
}

// Get fieldname
function getFieldName(input) {
    return input.id.charAt(0).toUpperCase() + input.id.slice(1)
}

// Event listeners
form.addEventListener('submit', function (e) {
    e.preventDefault();
    if (!checkRequired([username, email, password])) { 
        form.submit();
    }
});


// Check Login Error

let lgForm = document.querySelector('.form-lg')
let lgUsername = document.querySelector('.username-2')
let lgUsernameError = document.querySelector(".username-error-2")
let lgPassword = document.querySelector('.password-2')
let lgPasswordError = document.querySelector(".password-error-2")

function showError2(input, message) {
    const formControl2 = input.parentElement
    formControl2.className = 'form-control2 error'
    const small2 = formControl2.querySelector('small')
    small2.innerText = message
}

function showSuccess2(input) {
    const formControl2 = input.parentElement
    formControl2.className = 'form-control2 success'
    const small2 = formControl2.querySelector('small')
    small2.innerText = '';
}

// Check length input user name
lgUsername.addEventListener("input", function(){
    if (lgUsername.value.length < 4) {
        lgUsernameError.textContent = "*Tài khoản phải có ít nhất 4 kí tự."
    }else if(lgUsername.value.length > 20){
        lgUsernameError.textContent = "*Tài khoản không được dài hơn 20 kí tự.";
    }else {
        lgUsernameError.textContent = "";
    }
})

// Check length input passwrod
lgPassword.addEventListener("input", function(){
    if (lgPassword.value.length < 4) {
        lgPasswordError.textContent = "*Mật khẩu phải có ít nhất 4 kí tự."
    }else if (lgPassword.value.length > 20){
        lgPasswordError.textContent = "*Mật khẩu không được dài hơn 20 kí tự."
    }else {
        lgPasswordError.textContent = "";
    }
})

function checkRequiredLg(inputArr2) {
    let isRequiredLg = false
    inputArr2.forEach(function(input){
        if (input.value.trim() === '') {
            showError2(input, `*${getFieldNameLg(input)} Hãy điền vào chỗ trống!`)
            isRequiredLg = true
        }else {
            showSuccess2(input)
        }
    })

    return isRequiredLg
}

function getFieldNameLg(input) {
    return input.id.charAt(0).toUpperCase() + input.id.slice(1)
}

lgForm.addEventListener('submit', function (e){
    e.preventDefault()

    if (!checkRequiredLg([lgUsername, lgPassword])) {
        lgForm.submit();
    }
})

