

$('.notification-manage').change(function() {
    var $this = $(this);
    var token = $('meta[name="csrf-token"]').attr('content');
    var id = $this.attr('id');

    var message_type = $this.attr('message-type');
    var role = $this.attr('role');
    var event_id = $this.parent().parent().parent().attr('event-id');
    var value = $('#'+id+':checked').val();

    if(value == null){
        value = 0;
    }
    else{
        value = 1;
    }

    $.ajax({
        type: "post",
        url: '/events/savenotifications/',
        data: {
            _csrf : token,
            'message_type': message_type,
            'role' : role,
            'event_id' : event_id,
            'value' : value
        },
        success: function(response, status){
            swal({
                    title: "Изменено!",
                    text: "Поздравляем, изменения сохранены.",
                    type: "success",
                    showCancelButton: false,
                    confirmButtonColor: "#76FF03",
                    confirmButtonText: "Ok",
                    closeOnConfirm: true,
                },
                function(isConfirm){
                });

        },
        error: function(response, status){
            swal("Ошибка!", "Что-то пошло не так при обновлении данных.", "error");

        }
    });
});

$('.saveMessageTemplate').click(function() {
    var $this = $(this);
    var token = $('meta[name="csrf-token"]').attr('content');
    var id = $this.attr('id');

    var message_type = $this.parent().attr('message-type')
    var event_id = $this.parent().parent().attr('event-id');
    var adminMessage = $this.parent().children('div').children('textarea[role="admin"]').val();
    var moderatorMessage = $this.parent().children('div').children('textarea[role="moderator"]').val();
    var registeredUserMessage = $this.parent().children('div').children('textarea[role="registeredUser"]').val();

    $.ajax({
        type: "post",
        url: '/events/savemessagetemplates/',
        data: {
            _csrf : token,
            'message_type': message_type,
            'event_id' : event_id,
            'adminMessage' : adminMessage,
            'moderatorMessage' : moderatorMessage,
            'registeredUserMessage' : registeredUserMessage
        },
        success: function(response, status){
            swal({
                    title: "Изменено!",
                    text: "Поздравляем, изменения сохранены.",
                    type: "success",
                    showCancelButton: false,
                    confirmButtonColor: "#76FF03",
                    confirmButtonText: "Ok",
                    closeOnConfirm: true,
                },
                function(isConfirm){
                });

        },
        error: function(response, status){
            swal("Ошибка!", "Что-то пошло не так при обновлении данных.", "error");

        }
    });
});


var channel = pusher.subscribe('private-admin-channel');

channel.bind('something-changed', function(data) {
    runHTML5Notification(data.notification.title, data.notification.message, data.notification.image, data.notification.url);
});