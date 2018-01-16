/* form validation using jquery */
$(document).ready(function () {

    $('#password').parent().append('<span class=" hide_password_details help-block" id="password_error"></span>');
    $('#password_check').parent().append('<span class=" hide_password_check_details help-block" id="password_check_error"></span>');
    /* client side validation for password */
    $('.hide_password_details').hide();

    function passwordValidate(password) {
        if ('' === password) {
            $('#password').parent().addClass('has-error');
            $('#password_error').html('Password is required').show();
            return false;
        }
        return true;
    }

    $('#password').focus(function () {
        $('#password_error').hide();
        $('#password').parent().removeClass('has-error');
    });
    $('#password').blur(function () {
        var password = $('#password').val();
        passwordValidate(password);
    });

    /* client side validation for password which is entered again */
    var password_check = $('#password_check').val();
    $('.hide_password_check_details').hide();

    function passwordCheckValidate(password, password_check) {
        if (true === passwordValidate(password)) {
            if ('' === password_check) {
                $('#password_check').parent().addClass('has-error');
                $('#password_check_error').html('Password is required').show();
                return false;
            } else if (password != password_check) {
                $('#password_check').parent().addClass('has-error');
                $('#password_check_error').html('The two passwords do not match').show();
                return false;
            }
        }
    }

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
        if(false === passwordValidate(password) ||
            false === passwordCheckValidate(password, password_check)
        ){
            return false;
        }
    });
});

