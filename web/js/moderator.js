

var channel = pusher.subscribe('private-moderator-channel');

channel.bind('something-changed', function(data) {
    runHTML5Notification(data.notification.title, data.notification.message, data.notification.image, data.notification.url);
});