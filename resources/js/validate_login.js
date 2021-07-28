const str_email = /^(([^<>()\[\]\\.,;:\s@'"]+(\.[^<>()\[\]\\.,;:\s'@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
const str_phone = /^(0)[0-9]{9}/;
let input_email = $("#email");
let input_name = $("#name");
let input_password = $("#password");
let input_password_confirm = $("#password_confirm");
let input_phone = $("#phone");
let input_avatar = $("#avatar");

let button_login = $("#button_login");
let button_register = $("#button_register");
let button_edit = $("#button_edit");

let form_login = $("#form_login");
let form_register = $("#form_register");
let form_edit = $("#form_edit");

let check_email = false;
let check_pass = false;
let check_name = false;
let check_confirm = false;

$(document).ready(function() {
    input_email.blur(validateEmail);
    input_password.blur(validatePass);
    input_name.blur(validateName);
    input_password_confirm.blur(validateConfirm);
    input_phone.blur(validatePhone);

    button_login.click(login);
    button_register.click(register);
});
function login(e) {
    e.preventDefault();
    validateEmail();
    validatePass();
    if (check_email && check_pass) {
        form_login.submit();
    }
}

function register(e) {
    e.preventDefault();
    validateEmail();
    validatePass();
    validateName();
    validateConfirm();
    if (check_email && check_pass && check_name && check_confirm) {
        form_register.submit();
    }
}

function validateEmail() {
    check_email = false;
    let email = input_email.val();
    if (email.length == 0) {
        $("#mess_email").html("Email is required");
    } else if (!str_email.test(email)) {
        $("#mess_email").html("Please enter correct email format");
    } else {
        $("#mess_email").html("");
        check_email = true;
    }
}

function validatePass() {
    check_pass = false;
    let password = input_password.val();
    if (password.length == 0) {
        $("#mess_pass").html("Password is required");
    } else if (password.length < 8) {
        $("#mess_pass").html(
            "Please lengthen this text to 8 characters or more "
        );
    } else {
        $("#mess_pass").html("");
        check_pass = true;
    }
}

function validateConfirm() {
    check_confirm = false;
    let password = input_password.val();
    let rePassword = input_password_confirm.val();
    if (password !== rePassword) {
        $("#mess_confirm").html("Not matching password !");
    } else {
        $("#mess_confirm").html("");
        check_confirm = true;
    }
}

function validateName() {
    let name = input_name.val();
    console.log(name);
    if (name.length == 0) {
        $("#mess_name").html("Name is required");
    } else if (name.length < 8) {
        $("#mess_name").html(
            "Please lengthen this text to 6 characters or more"
        );
    } else {
        $("#mess_name").html("");
        check_name = true;
    }
}

function validatePhone() {
    let phone = input_phone.val();
    if (!str_phone.test(phone)) {
        $("#mess_phone").html("Please enter correct phone format");
    } else {
        $("#mess_phone").html("");
    }
}
