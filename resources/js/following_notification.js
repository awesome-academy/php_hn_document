function trans(key, replace = {}) {
    let translation = key.split('.').reduce((t, i) => t[i] || null, window.translations);

    for (var placeholder in replace) {
        translation = translation.replace(`:${placeholder}`, replace[placeholder]);
    }

    return translation;
}

var down = false;
$('#bell').click(function (e) {
    var color = $(this).text();
    if (down) {
        $('#box').css('height', '0px');
        $('#box').css('opacity', '0');
        down = false;
    } else {
        $('#box').css('height', 'auto');
        $('#box').css('opacity', '1');
        down = true;
    }
});

Pusher.logToConsole = true;
var pusher = new Pusher(window.env_key, {
    cluster: 'ap1'
});
var url = window.location.origin; 
var notificationsWrapper = $('#notify');
var notificationsBell = $('#bell');
var notificationsSpan = notificationsBell.find('span[data-count]');
var notificationsCount = parseInt(notificationsSpan.data('count'));
var notifications = notificationsWrapper.find('#notification-content');
var user = $('#userLogin').val();
var channelName = 'following-notification.' + user
var channel = pusher.subscribe(channelName);
channel.bind('SendFollowing', function (data) {
    var route = url + "/mark/" + data.id;
    var existingNotifications = notifications.html();
    var newNotificationHtml =
        `<div class="notifications-item"> <img src="` + data['image'] + `">
                    <a href="` + route + `">
                        <div class="text">
                            <h4>` + data['name'] + `</h4>
                            <p>` + trans(data['following']) + `</p>
                        </div>
                    </a>
                 </div>`;
    notifications.html(newNotificationHtml + existingNotifications);
    notificationsCount += 1;
    notificationsSpan.text(notificationsCount)
    notificationsWrapper.find('.notif-count').text(notificationsCount);
    notificationsWrapper.show();
});
