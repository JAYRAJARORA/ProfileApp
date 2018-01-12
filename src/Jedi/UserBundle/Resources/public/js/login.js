$(document).ready(function () {

    /** checking the details again if the fields are invalid do not submit the form */
    $('#submit').click(function () {
        var username = $('#username').val();
        var password = $('#password').val();
        var is_error = true;

        if (false === passwordValidate(password)) {
            is_error = false;
        }
        if (false === usernameValidate(username)) {
            is_error = false;
        }
        if(false === is_error) {
            return false;
        }
    });

    /** Client side Validate for username */
    function usernameValidate(username) {
        if ('' === username) {
            $('#username').parent().addClass('has-error');
            $('#username_check').html('Please enter your username').show();
            return false;
        }
    }
    /** hide event on focus and call the validate function on blur */
    $('#username').focus(function () {
        $('#username_check').hide().parent().removeClass('has-error');
    });
    $('#username').blur(function () {
        var username = $('#username').val();
        usernameValidate(username);
    });

    /** client side validation for password */
    function passwordValidate(password) {
        if ('' === password) {
            $('#password').parent().addClass('has-error');
            $('#password_error').html('Please enter your password').show();
            return false;
        }
    }

    /** hide event on focus and call the validate function on blur */
    $('#password').focus(function () {
        $('#password_error').hide().parent().removeClass('has-error');
    });
    $('#password').blur(function () {
        var password = $('#password').val();
        passwordValidate(password);
    });
});