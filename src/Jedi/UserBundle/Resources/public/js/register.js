/* form validation using jquery */
$(document).ready(function () {

    $('#email').parent().append('<span class="hide_email_details help-block" id="email_check">');
    $('#username').parent().append(' <span class="hide_firstname_details help-block"id="username_check"></span>');
    $('#password').parent().append('<span class=" hide_password_details help-block" id="password_error">');
    $('#password_check').parent().append('<span class=" hide_password_check_details help-block" id="password_check_error">');

    var alphabet_regex = /^[\sA-Za-z]+$/;
    $('.hide_username_details').hide();

    function usernameValidate(username, alphabet_regex) {
        if ('' === username) {
            $('#username').parent().addClass('has-error');
            $('#username_check').html('Please enter your username').show();
            return false;
        } else if (!alphabet_regex.test(username)) {
            $('#username').parent().addClass('has-error');
            $('#username_check').html('Username can contain letters only').show();
            return false;
        }
    }
    /* validation upon blur and focus */
    $('#username').focus(function () {
        $('#username_check').hide().parent().removeClass('has-error');
    });
    $('#username').blur(function () {
        var username = $('#username').val();
        usernameValidate(username, alphabet_regex);
    });

    /* client side validation for email */
    var email_regex = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;
    $('.hide_email_details').hide();

    function emailValidate(email, email_regex) {
        if ('' === email) {
            $('#email').parent().addClass('has-error');
            $('#email_check').html('Please enter your email').show();
            return false;
        } else if (!email_regex.test(email)) {
            $('#email').parent().addClass('has-error');
            $('#email_check').html('Invalid email format').show();
            return false;
        }
        return true;

    }
    /* validation upon blur and focus */
    $('#email').focus(function () {
        $('#email_check').hide().parent().removeClass('has-error');
    });
    $('#email').blur(function () {
        var email = $('#email').val();
        emailValidate(email, email_regex);
    });

    /* client side validation for password */
    var password_regex = /^.*(?=.{8,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$/;
    $('.hide_password_details').hide();
    $('.hide_password_check_details').hide();

    function passwordValidate(password) {
        if ('' === password) {
            $('#password').parent().addClass('has-error');
            $('#password_error').html('Please enter your password').show();
            return false;
        }
    }

    /* validation upon blur and focus */
    $('#password').focus(function () {
        $('#password_error').hide();
        $('#password').parent().removeClass('has-error');
    });
    $('#password').blur(function () {
        var password = $('#password').val();
        passwordValidate(password);
    });

    /* client side validation for password again */
    var password_check = $('#password_check').val();

    function passwordCheckValidate(password, password_check) {
        if ('' === password_check) {
            $('#password_check').parent().addClass('has-error');
            $('#password_check_error').html('Please enter your password again').show();
            return false;

        } else if (password != password_check) {
            $('#password_check').parent().addClass('has-error');
            $('#password_check_error').html('The two passwords do not match').show();
            return false;
        }
    }

    /* validation upon blur and focus */
    $('#password_check').focus(function () {
        $('#password_check_error').hide();
        $('#password_check').parent().removeClass('has-error');
    });
    $('#password_check').blur(function () {
        var password = $('#password').val();
        var password_check = $('#password_check').val();
        passwordCheckValidate(password, password_check);
    });

    /* checking the fields again upon submit */
    $('#submit').click(function () {
        var password = $('#password').val();
        var password_check = $('#password_check').val();
        var username = $('#username').val();
        var email = $('#email').val();
        var is_error = true;

        if (false === usernameValidate(username, alphabet_regex)) {
            is_error = false;
        }
        if (false === emailValidate(email, email_regex)) {
            is_error = false;
        }
        if (false === passwordValidate(password, password_regex)) {
            is_error = false;
        }
        if (false === passwordCheckValidate(password, password_check)) {
            is_error = false;
        }
        if (false === is_error) {
            return false;
        }
    });
});