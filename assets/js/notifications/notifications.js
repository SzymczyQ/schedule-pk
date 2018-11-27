import toastr from 'toastr';

toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": false,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "200",
    "hideDuration": "500",
    "timeOut": "2500",
    "extendedTimeOut": "500",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
};

let container = $('#notifications_container');
let notifications = container.data('notifications');

$.each(notifications, function (type, messages) {
    $.each(messages, function (index, message) {
        let title = container.data(type + '-title');
        toastr[type](message, title);
    });
});

