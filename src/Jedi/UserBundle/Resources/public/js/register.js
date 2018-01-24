/* form validation using jquery */
$(document).ready(function () {

    $('#email').parent().append('<span class="hide_email_details help-block" id="email_check">');
    $('#username').parent().append(' <span class="hide_username_details help-block"id="username_check"></span>');
    $('#firstname').parent().append(' <span class="hide_firstname_details help-block"id="firstname_check"></span>');
    $('#lastname').parent().append(' <span class="hide_lastname_details help-block"id="lastname_check"></span>');
    $('#password').parent().append('<span class=" hide_password_details help-block" id="password_error">');
    $('#password_check').parent().append('<span class=" hide_password_check_details help-block" id="password_check_error">');

    var username_regex = /^[a-zA-Z0-9]+$/;
    $('.hide_username_details').hide();
    var alphabet_regex = /^[a-zA-Z]+$/;

    function usernameValidate(username, username_regex) {
        if ('' === username) {
            $('#username').parent().addClass('has-error');
            $('#username_check').html('Please enter your username').show();
            return false;
        } else if (!username_regex.test(username)) {
            $('#username').parent().addClass('has-error');
            $('#username_check').html('Username can contain letters amd digits only').show();
            return false;
        }
    }
    /* validation upon blur and focus */
    $('#username').focus(function () {
        $('#username_check').hide().parent().removeClass('has-error');
    });
    $('#username').blur(function () {
        var username = $('#username').val();
        usernameValidate(username, username_regex);
    });

    $('.hide_firstname_details').hide();

    function firstnameValidate(firstname, alphabet_regex) {
        if ('' === firstname) {
            $('#firstname').parent().addClass('has-error');
            $('#firstname_check').html('Please enter your firstname').show();
            return false;
        } else if (!alphabet_regex.test(firstname)) {
            $('#firstname').parent().addClass('has-error');
            $('#firstname_check').html('Firstname can contain letters only').show();
            return false;
        }
    }
    /* validation upon blur and focus */
    $('#firstname').focus(function () {
        $('#firstname_check').hide().parent().removeClass('has-error');
    });
    $('#firstname').blur(function () {
        var firstname = $('#firstname').val();
        firstnameValidate(firstname, alphabet_regex);
    });




    $('.hide_lastname_details').hide();

    function lastnameValidate(lastname, alphabet_regex) {
        if ('' === lastname) {
            $('#lastname').parent().addClass('has-error');
            $('#lastname_check').html('Please enter your lastname').show();
            return false;
        } else if (!alphabet_regex.test(lastname)) {
            $('#lastname').parent().addClass('has-error');
            $('#lastname_check').html('Lastname can contain letters only').show();
            return false;
        }
    }
    /* validation upon blur and focus */
    $('#lastname').focus(function () {
        $('#lastname_check').hide().parent().removeClass('has-error');
    });
    $('#lastname').blur(function () {
        var lastname = $('#lastname').val();
        lastnameValidate(lastname, alphabet_regex);
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
        if (true === emailValidate(email, email_regex)) {
            $.ajax({
                type : 'POST',
                url :  '/app_dev.php/register/check_email',
                dataType: 'json',
                data : {
                    email : email
                },
                success : function (response) {
                    var jsonresponse = response;
                    if (jsonresponse !==null) {
                        if (jsonresponse.hasOwnProperty('error')) {
                            $('#email').parent().addClass('has-error');
                            $('#email_check').html(jsonresponse.error).show();
                        } else if (jsonresponse.hasOwnProperty('success')) {
                        }
                    }
                },
                error : function (response) {
                }
            });
        }
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
        var firstname = $('#firstname').val();
        var lastname = $('#lastname').val();
        var is_error = true;

        if (false === usernameValidate(username, username_regex)) {
            is_error = false;
        }
        if (false === firstnameValidate(firstname, alphabet_regex)) {
            is_error = false;
        }
        if (false === lastnameValidate(lastname, alphabet_regex)) {
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