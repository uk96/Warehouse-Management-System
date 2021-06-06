$(document).ready(function(){
    $(".text-input").focusin(function(){
        $(this).parent().css("border", "1px solid #0069B4");
    });
    $(".text-input").focusout(function(){
        $(this).parent().css("border", "1px solid #C8C8C8");
    });
    $("#user-icon").click(function(){
        $("#logout-card").toggleClass("hide");
    });
    $("#login-button").click(function() {
        $("#login-button").addClass("hide");
        $("#register-button").removeClass("hide");
        $("#register-card").addClass("hide");
        $("#login-card").removeClass("hide");        
    });
    $("#register-button").click(function() {
        $("#register-button").addClass("hide");
        $("#login-button").removeClass("hide");
        $("#login-card").addClass("hide");
        $("#register-card").removeClass("hide");   
    });
    $(".userEmail").focusout(function (event) {
        if(/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(event.target.value)) {
            event.target.parentElement.nextElementSibling.classList.add('hide');
        } else {
            event.target.parentElement.nextElementSibling.classList.remove('hide');
        }
    });
    $(".password").focusout(function (event) {
        if(event.target.value) {
            event.target.parentElement.nextElementSibling.classList.add('hide');
        } else {
            event.target.parentElement.nextElementSibling.classList.remove('hide');
        }
    });
    $("#fullName").focusout(function (event) {
        if(event.target.value) {
            event.target.parentElement.nextElementSibling.classList.add('hide');
        } else {
            event.target.parentElement.nextElementSibling.classList.remove('hide');
        }
    });
    $("#confirmPassword").focusout(function (event) {
        if(event.target.value === $("#password").val()) {
            event.target.parentElement.nextElementSibling.classList.add('hide');
        } else {
            event.target.parentElement.nextElementSibling.classList.remove('hide');
        }
    });
});