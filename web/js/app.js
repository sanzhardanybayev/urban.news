$(document).ready(function () {
    $('.materialboxed').materialbox();
    $('ul.tabs').tabs();
    $('.modal').modal();
    $('select').material_select();
    $('.dropdown-button').dropdown({
            inDuration: 300,
            outDuration: 225,
            constrain_width: true, // Does not change width of dropdown to that of the activator
            hover: true, // Activate on hover
            gutter: 0, // Spacing from edge
            belowOrigin: true, // Displays dropdown below the button
            alignment: 'left' // Displays dropdown with edge aligned to the left of button
        }
    );

});

$allowResend = true;
function validateEmail(email) {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

$("#resend-form-email").keyup(function () {
    if (validateEmail($(this).val())) {
        $("#resendConfirmationEmail").removeAttr('disabled');
    } else {
        $("#resendConfirmationEmail").attr('disabled', 'disabled');
    }
});

$("#resend-form-email").on('input', function () {
    if (validateEmail($(this).val())) {
        $("#resendConfirmationEmail").removeAttr('disabled');
    } else {
        $("#resendConfirmationEmail").attr('disabled', 'disabled');
    }
});


$('#saveAccountInfo').click(function () {

    // $('.send').addClass('hide');

    if ($allowResend) {

        $('.send').addClass('hide');
        $('.sk-fading-circle').removeClass('hide');

        var $this = $(this);
        var token = $('meta[name="csrf-token"]').attr('content');
        var link = $this.parent().parent().parent().attr('action');
        var email = $('input[name="settings-form[email]"]').val();
        var username = $('input[name="settings-form[username]"]').val();
        var new_password = $('input[name="settings-form[new_password]"]').val();
        var current_password = $('input[name="settings-form[current_password]"]').val();
        var external = true;

        $.ajax({
            type: "post",
            url: link,
            data: {
                _csrf: token,
                "settings-form[email]": email,
                "settings-form[username]": username,
                "settings-form[new_password]": new_password,
                "settings-form[current_password]": current_password,
                "external": external,
            },
            success: function (response, status, data) {
                $allowResend = false;

                $('.airPlane span:nth-child(2)').addClass('go');
                setTimeout(function () {
                    // Making less vulnerable
                    setTimeout(function () {
                        swal("Отправлено!", data.responseJSON, "success");
                        $('.airPlane span:nth-child(2)').removeClass('go');
                        $('.sk-fading-circle').addClass('hide');
                        $('.send').removeClass('hide');
                        location.reload();
                        // $this.parent().hide('slow');
                        // $('meta[name="csrf-token"]').remove();
                        // $('input[name="_csrf"]').remove();
                        // $this.remove();
                    }, 2500);

                }, 1000);


            },
            error: function (response, status, data) {
                $('.sk-fading-circle').addClass('hide');
                $('.send').removeClass('hide');
                swal(response.status + " Ошибка!", response.responseJSON, "error");
            }
        });
    }
});

$('.deleteUser').click(function () {
    var $this = $(this);
    var token = $('meta[name="csrf-token"]').attr('content');
    var user_id = $this.attr('user-id');
    var link = "/user/delete/" + user_id + "/";

    swal({
            title: "Вы уверены?",
            text: "Удалив, Вы не сможете восстановить пользователя!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#ff2900",
            cancelButtonText: "Отмена",
            confirmButtonText: "Удалить!",
            closeOnConfirm: false
        },
        function () {

            $.ajax({
                type: "post",
                url: link,
                data: {
                    _csrf: token,
                },
                success: function (response, status) {

                    $this.parent().parent().hide('slow');

                    swal("Удален!", "Пользователь  был удален.", "success");

                },
                error: function (response, status) {
                    swal("Ошибка!", "Что-то пошло не так при удалении пользователя.", "error");
                }
            });

        });
});


$('#resendConfirmationEmail').click(function () {

    // $('.send').addClass('hide');

    if ($allowResend) {

        $('.send').addClass('hide');
        $('.sk-fading-circle').removeClass('hide');

        var $this = $(this);
        var token = $('meta[name="csrf-token"]').attr('content');
        var link = $this.parent().parent().attr('action');
        var email = $("#resend-form-email").val();


        $.ajax({
            type: "post",
            url: link,
            data: {
                _csrf: token,
                "resend-form[email]": email
            },
            success: function (response, status, data) {
                $allowResend = false;

                $('.airPlane span:nth-child(2)').addClass('go');
                setTimeout(function () {

                    $this.addClass('shortify');

                    // Making less vulnerable
                    setTimeout(function () {
                        swal("Отправлено!", data.responseJSON, "success");
                        $this.parent().hide('slow');
                        $('meta[name="csrf-token"]').remove();
                        $('input[name="_csrf"]').remove();
                        $this.remove();
                    }, 2500);

                }, 1000);

            },
            error: function (response, status, data) {
                $('.sk-fading-circle').addClass('hide');
                $('.send').removeClass('hide');
                swal(response.status + " Ошибка!", response.responseJSON, "error");
            }
        });
    }
});

$('#addUser').click(function () {

    var $this = $(this);
    var token = $('meta[name="csrf-token"]').attr('content');

    var link = $this.parent().parent().attr('action');
    var email = $("#register-form-email").val();
    var password = $("#register-form-password").val();
    var username = $("#register-form-username").val();

    if ($('#registration-form .form-group.has-error').length <= 0) {
        $('#registration-form .send').addClass('hide');
        $('#registration-form .sk-fading-circle').removeClass('hide');
        $.ajax({
            type: "post",
            url: link,
            data: {
                _csrf: token,
                'remote': true,
                "register-form[email]": email,
                "register-form[username]": username,
                "register-form[password]": password,
            },
            success: function (response, status, data) {

                $('#registration-form .airPlane span:nth-child(2)').addClass('go');
                setTimeout(function () {

                    $('#registration-form .send').removeClass('hide');
                    $('#registration-form .airPlane span:nth-child(2)').removeClass('go');
                    $('#registration-form .sk-fading-circle').addClass('hide');
                    $("#registration-form").attr('action', '/user/register/');
                    document.getElementById("registration-form").reset();
                    // Making less vulnerable

                    swal("Добавлен!", "Пользователь успешно добавлен", "success");

                }, 1000);

            },
            error: function (response, status, data) {
                $('#registration-form .sk-fading-circle').addClass('hide');
                $('#registration-form .send').removeClass('hide');
                swal(response.status + " Ошибка!", response.responseJSON, "error");
            }
        });
    } else {
        swal("Ошибка!", "Исправьте ошибки", "error");
    }
});

$('.deleteButton').click(function () {
    var $this = $(this);
    var token = $('meta[name="csrf-token"]').attr('content');
    var link = $this.attr('link');
    var redirect = false;

    var string = document.location.pathname,
        substring = "news";

    if (string.indexOf(substring) !== -1) {
        redirect = true;
    }

    swal({
            title: "Вы уверены?",
            text: "Удалив, Вы не сможете восстановить статью!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#ff2900",
            confirmButtonText: "Удалить!",
            closeOnConfirm: false
        },
        function () {

            $.ajax({
                type: "post",
                url: link,
                data: {
                    _csrf: token
                },
                success: function (response, status) {
                    if (redirect) {
                        $('.card').hide('slow');
                    }
                    else {
                        $this.parent().parent().hide('slow');
                    }
                    swal("Удалено!", "Статья была удалена.", "success");
                    if (redirect) {
                        setTimeout(function () {
                            window.location.replace("/");
                        }, 3000);
                    }

                },
                error: function (response, status) {
                    swal("Ошибка!", "Что-то пошло не так при удалении статьи.", "error");
                }
            });

        });

});

$('.publishIt').change(function () {
    var $this = $(this);
    var token = $('meta[name="csrf-token"]').attr('content');
    var action = $this.attr('action');
    var article_id = $this.attr('article_id');
    var status = $this.is(':checked');
    console.log(article_id);
    console.log(status);


    $.ajax({
        type: "post",
        url: action,
        data: {
            _csrf: token,
            "status": status
        },
        success: function (response, status) {
            swal("Изменено!", "Поздравляем, статус статьи был изменен.", "success");

        },
        error: function (response, status) {
            swal("Ошибка!", "Что-то пошло не так при изменении статуса статьи.", "error");

        }
    });


});

$('.userRoleValue').change(function () {
    var $this = $(this);
    var token = $('meta[name="csrf-token"]').attr('content');
    var id = $this.attr('name');
    var role = $this.val();
    var action = '/user/change/role/' + id + '/' + role + '/';

    $.ajax({
        type: "post",
        url: action,
        data: {
            _csrf: token
        },
        success: function (response, status) {
            swal({
                    title: "Изменено!",
                    text: "Поздравляем, роль успешно обновлена.",
                    type: "success",
                    showCancelButton: false,
                    confirmButtonColor: "#76FF03",
                    confirmButtonText: "Ok",
                    closeOnConfirm: true,
                },
                function (isConfirm) {
                });

        },
        error: function (response, status) {
            swal("Ошибка!", "Что-то пошло не так при изменении роли пользователя.", "error");

        }
    });


});

$('.ban').change(function () {
    var $this = $(this);
    var token = $('meta[name="csrf-token"]').attr('content');
    var action = '/user/ban/' + $this.attr('user_id') + '/';
    console.log(action);
    $.ajax({
        type: "post",
        url: action,
        data: {
            _csrf: token
        },
        success: function (response, status) {
            swal({
                    title: "Обновлено!",
                    text: "Поздравляем, статус пользователя обновлен.",
                    type: "success",
                    showCancelButton: false,
                    confirmButtonColor: "#76FF03",
                    confirmButtonText: "Ok",
                    closeOnConfirm: true,
                },
                function (isConfirm) {
                });
        },
        error: function (response, status) {
            swal("Ошибка!", "Что-то пошло не так при обновлении статуса .", "error");
        }
    });


});

$('.notificationChoice').change(function () {
    var $this = $(this);
    var token = $('meta[name="csrf-token"]').attr('content');
    var user_id = $("input[name='user_id_notify']").val();

    var emailNotification = $("#emailNotification:checked").val();
    var browserNotification = $("#browserNotification:checked").val();

    if (emailNotification == null) {
        emailNotification = 0;
    }
    else {
        emailNotification = 1;
    }
    if (browserNotification == null) {
        browserNotification = 0;
    }
    else {
        browserNotification = 1;
    }


    $.ajax({
        type: "post",
        url: '/user/settings/notifications/',
        data: {
            _csrf: token,
            'user_id': user_id,
            'browser': browserNotification,
            'email': emailNotification
        },
        success: function (response, status) {
            swal({
                    title: "Изменено!",
                    text: "Поздравляем, изменения сохранены.",
                    type: "success",
                    showCancelButton: false,
                    confirmButtonColor: "#76FF03",
                    confirmButtonText: "Ok",
                    closeOnConfirm: true,
                },
                function (isConfirm) {
                });

        },
        error: function (response, status) {
            swal("Ошибка!", "Что-то пошло не так при обновлении данных.", "error");

        }
    });
});

$('.whoToSent').change(function () {
    var $this = $(this);
    var chosenReceivers = $this.val();
    switch (chosenReceivers) {
        case 'certainUser':
            if($("#animationContainer").hasClass('minified')){
                $("#animationContainer").removeClass('minified');
                setTimeout(function () {
                    $("#groupSelection").removeClass('slideInLeft');
                    $("#groupSelection").addClass('slideOutRight');
                    ($("#userSelection").hasClass('slideOutRight')) ? '' : $("#userSelection").addClass('slideOutRight');

                    setTimeout(function () {
                        $("#groupSelection").css('display', 'none');
                        $("#userSelection").removeClass('slideOutRight');
                        $("#userSelection").css('display', 'block');
                        $("#userSelection").addClass('slideInLeft');
                    }, 500);
                }, 500);
            } else {
                $("#groupSelection").removeClass('slideInLeft');
                $("#groupSelection").addClass('slideOutRight');
                ($("#userSelection").hasClass('slideOutRight')) ? '' : $("#userSelection").addClass('slideOutRight');

                setTimeout(function () {
                    $("#groupSelection").css('display', 'none');
                    $("#userSelection").removeClass('slideOutRight');
                    $("#userSelection").css('display', 'block');
                    $("#userSelection").addClass('slideInLeft');
                }, 500);
            }
            break;
        case 'groupOfPeople':
            if($("#animationContainer").hasClass('minified')) {
                $("#animationContainer").removeClass('minified');
                setTimeout(function () {
                    ($("#userSelection").hasClass('slideInLeft')) ? $("#userSelection").removeClass('slideInLeft') : '';
                    ($("#groupSelection").hasClass('slideOutRight')) ? '' : $("#groupSelection").addClass('slideOutRight');

                    if (!$("#userSelection").hasClass('slideOutRight')) {
                        $("#userSelection").addClass('slideOutRight');
                    }
                    setTimeout(function () {
                        $("#userSelection").css('display', 'none');
                        $("#groupSelection").removeClass('slideOutRight');
                        $("#groupSelection").css('display', 'block');
                        $("#groupSelection").addClass('slideInLeft');
                    }, 500);
                }, 500);
            } else {
                ($("#userSelection").hasClass('slideInLeft')) ? $("#userSelection").removeClass('slideInLeft') : '';
                ($("#groupSelection").hasClass('slideOutRight')) ? '' : $("#groupSelection").addClass('slideOutRight');

                if (!$("#userSelection").hasClass('slideOutRight')) {
                    $("#userSelection").addClass('slideOutRight');
                }
                setTimeout(function () {
                    $("#userSelection").css('display', 'none');
                    $("#groupSelection").removeClass('slideOutRight');
                    $("#groupSelection").css('display', 'block');
                    $("#groupSelection").addClass('slideInLeft');
                }, 500);
            }
            break;
        case 'all':
            if ($("#userSelection").hasClass('slideInLeft')
                || (!$("#userSelection").hasClass('slideInLeft')
                && !$("#groupSelection").hasClass('slideInLeft'))) {
                $("#userSelection").addClass('slideOutRight');
                setTimeout(function () {
                    $("#animationContainer").addClass('minified');
                }, 500);
            } else if ($("#groupSelection").hasClass('slideInLeft')) {
                $("#groupSelection").addClass('slideOutRight');
                setTimeout(function () {
                    $("#animationContainer").addClass('minified');
                }, 500);
            }
            break;
    }
});

$('.notifyUsers .btn').click(function () {
    var $this = $(this);
    var token = $('meta[name="csrf-token"]').attr('content');
    var chosenReceivers = $('.whoToSent:checked').val();
    var action = '/notify/';
    var user_id = null;
    var groupName = null;
    var message = $('#messageFromAdmin').val();

    $('.notifyUsers .send').addClass('hide');
    $('.notifyUsers .sk-fading-circle').removeClass('hide');

    switch (chosenReceivers) {
        case 'certainUser' :
            user_id = $('#userId').val();
            break;
        case 'groupOfPeople' :
            groupName = $('#groupName').val();
            break;
    }


    $.ajax({
        type: "post",
        url: action,
        data: {
            _csrf: token,
            receivers: chosenReceivers,
            user_id: user_id,
            group_name: groupName,
            message: message
        },
        success: function (response, status) {
            $('.notifyUsers .airPlane span:nth-child(2)').addClass('go');
            setTimeout(function () {

                $('.notifyUsers .send').removeClass('hide');
                $('.notifyUsers .airPlane span:nth-child(2)').removeClass('go');
                $('.notifyUsers .sk-fading-circle').addClass('hide');

                swal("Отправлено!", "Сообщение успешно отправлено", "success");

            }, 1000);

        },
        error: function (response, status, data) {
            $('.notifyUsers .sk-fading-circle').addClass('hide');
            $('.notifyUsers .send').removeClass('hide');
            swal(response.status + " Ошибка!", response.responseJSON, "error");
        }
    });


});

$('#saveWebsiteSettings').click(function () {
    var token = $('meta[name="csrf-token"]').attr('content');
    var action = '/user/settings/websitesettings/';

    var amountOfNewsOnMainPage = $('#amountOfNewsOnMainPage').val();
    var amountOfNewsOnNewsPage = $('#amountOfNewsOnNewsPage').val();


    $('#saveWebsiteSettings .send').addClass('hide');
    $('#saveWebsiteSettings .sk-fading-circle').removeClass('hide');


    $.ajax({
        type: "post",
        url: action,
        data: {
            _csrf: token,
            remote: 'true',
            websiteSettingsForm : {
                                        amountOfNewsOnMainPage : amountOfNewsOnMainPage,
                                        amountOfNewsOnNewsPage : amountOfNewsOnNewsPage }
        },
        success: function (response, status) {

            $('.airPlane span:nth-child(2)').addClass('go');
            setTimeout(function () {

                $('#saveWebsiteSettings .send').removeClass('hide');
                $('.airPlane span:nth-child(2)').removeClass('go');
                $('#saveWebsiteSettings .sk-fading-circle').addClass('hide');

                swal("Отправлено!", "Сохранено", "success");

            }, 1000);

        },
        error: function (response, status, data) {
            $('#saveWebsiteSettings .sk-fading-circle').addClass('hide');
            $('#saveWebsiteSettings .send').removeClass('hide');
            swal(response.status + " Ошибка!", response.responseJSON, "error");
        }
    });


});

$("a[href='#modal3']").click(function () {
    if ($("#modal3").hasClass('flex')) {
        $("#modal3").removeClass('flex');
    } else {
        $("#modal3").addClass('flex');
    }
});