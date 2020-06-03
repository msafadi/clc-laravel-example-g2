require('./bootstrap');

Echo.private('orders')
    .listen('NewOrder', function(e) {
        console.log(e);
        alert(e.message);
    });

    Echo.private('App.User.' + window.userId)
    .notification((notification) => {
        console.log(notification);
        alert(notification.message);
    });
