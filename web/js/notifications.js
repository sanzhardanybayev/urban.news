// Enable pusher logging - don't include this in production
Pusher.logToConsole = false;


var pusher = new Pusher('34dc4395b1458c85b3ef', {
    cluster: 'ap2',
    encrypted: true,
    authEndpoint: '/user/settings/pusher/',
    auth: {
        headers: {
            'X-CSRF-Token': $("meta[name='csrf-token']").attr('content')
        }
    }
});

var channel = pusher.subscribe('private-global-channel');
var personalChannel = pusher.subscribe('private-personal-message-' + user_id);

channel.bind('something-changed', function (data) {
    runHTML5Notification('Сообщение от администратора', data.notification.message, data.notification.image, data.notification.url);
});

personalChannel.bind('something-changed', function (data) {
    runHTML5Notification('Сообщение от администратора', data.notification.message, data.notification.image, data.notification.url);
});


/* channel.bind('article-added', function (data) {
    runHTML5Notification(data.notification.title, data.notification.message, data.notification.image, data.notification.url);
});
*/

channel.bind('message-from-admin', function (data) {
    runHTML5Notification("Уведомление", data.notification.message, data.notification.image, data.notification.url);
});

    Notification.requestPermission(function (permission) {
});

function runHTML5Notification(title, text, notificationImage, notificationURL) {

    Materialize.toast(text, 4000) // 4000 is the duration of the toast

    if (Notification.permission === "granted") {
        var notification = new Notification(title, {
            body: text,
            icon: notificationImage
        });

        if(notificationURL != null){
            notification.onclick = function (event) {
                var url = notificationURL;
                event.preventDefault(); // prevent the browser from focusing the Notification's tab
                window.open(url, '_blank');
            }
        }

    }
    else if (Notification.permission !== 'denied') {
        Notification.requestPermission(function (permission) {
            if (permission === "granted") {
                var notification = new Notification(title, {
                    body: text,
                    icon: notificationImage
                });
                if(notificationURL != null){
                    notification.onclick = function (event) {
                        var url = notificationURL;
                        event.preventDefault(); // prevent the browser from focusing the Notification's tab
                        window.open(url, '_blank');
                    }
                }
            }
        });
    }

}


