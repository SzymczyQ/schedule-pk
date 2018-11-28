$(document).ready(function () {
    addCollectionType('add-usi');
    removeCollectionType('remove-usi')
});

function addCollectionType(handlerClass) {
    $(document).on('click', '.' + handlerClass, function (e) {
        e.preventDefault();

        let list = $($(this).attr('data-list'));
        let counter = list.data('widget-counter') | list.children().length;

        if (!counter) { counter = list.children().length; }

        let newWidget = list.attr('data-prototype');

        newWidget = newWidget.replace(/__name__/g, counter);

        counter++;
        list.data('widget-counter', counter);

        let newElem = $(list.attr('data-widget-tags')).html(newWidget);
        newElem.appendTo(list);
    });
}

function removeCollectionType(handlerClass) {
    $(document).on('click', '.' + handlerClass, function (e) {
        e.preventDefault();

        let li = $(this).parents('li');
        li.fadeOut('slow', function() {
            $(this).remove();
        });
    });
}
