$(document).ready(function () {

    /** checking the details again if the fields are invalid do not submit the form */
    $('#submit').click(function () {
        var username = $('#username').val();
        var password = $('#password').val();
        var is_error = true;

        if (false === passwordValidate(password) ) {
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



    /* success and error message for forgot password modal form */
    $('#successMessage').hide();
    $('#display_errors').hide();
    /** upon submit check for email else do the ajax request
     * ajax request sends the email entered and in response
     * gives the error or success message as jso
     */
    $('#forgot_pass_submit').on('click', function (event) {
        event.preventDefault();
        var modal_email = $('#modal_email').val();

        if ('' === modal_email) {
            $('#display_errors').parent().addClass('has-error');
            $('#display_errors').html('Email is required').show();
        } else {
            $('#forgot_pass_submit').html('<i class="fa fa-spinner fa-spin fa-1.5x fa-fw"></i>')
                .attr('disabled','disabled');
            $.ajax({
                type: 'POST',
                url: '/app_dev.php/send_email',
                dataType: 'json',
                data: {
                    email: modal_email
                },
                success: function (response) {
                    console.log(response);
                    var jsonresponse = response;
                    if (jsonresponse.hasOwnProperty('error')) {
                        $('#display_errors').parent().addClass('has-error');
                        $('#display_errors').addClass('error_response')
                            .html(jsonresponse.error).show();
                    } else if (jsonresponse.hasOwnProperty('success')) {
                        $('#successMessage').parent().addClass('has-success');
                        $('#successMessage').addClass('success_response')
                            .html(jsonresponse.success).show();
                    }
                    if ($('span').hasClass('error_response')) {
                        if ($('.error_response').length) {
                            $('#forgot_pass_submit').html('Send Email').removeAttr('disabled');
                            $('span').removeClass('error_response');
                        }
                    }
                    if ($('span').hasClass('success_response')) {
                        if ($('.success_response').length) {
                            $('#forgot_pass_submit').html('Send Email').removeAttr('disabled');
                            $('span').removeClass('success_response');
                        }
                    }

                },
                error: function (response) {
                    if ($('span').hasClass('error_response')) {
                        if ($('.error_response').length) {
                            $('#forgot_pass_submit').html('Send Email').removeAttr('disabled');
                            $('span').removeClass('error_response');
                        }
                    }
                }
            });
        }

        $('#modal_email').focus(function () {
            if ($('#display_errors').parent().hasClass('has-error')) {
                $('#display_errors').hide();
                $('#display_errors').parent().removeClass('has-error');
            } else if ($('#successMessage').parent().hasClass('has-success')) {
                $('#successMessage').hide();
                $('#successMessage').parent().removeClass('has-success');
            }
        });
    });




























});








