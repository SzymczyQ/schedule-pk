$(document).ready(function () {
    addCollectionType('add-usi');
    removeCollectionType('remove-usi');
    loadGroupInfo();
});

function loadGroupInfo() {
    let groupData = $('#user_school_data_list').data('group-data');

    $(document).on('change', '.user-school-info-group', function (event) {
        let selectedValue = $(this).val();

        if (selectedValue in groupData) {
            let groupInfo = groupData[selectedValue];
            let parentLi = $(this).parents('li');

            $(parentLi).find('.user-school-info-year').val(groupInfo['yearName']);
            $(parentLi).find('.user-school-info-cycle').val(groupInfo['cycleName']);
            $(parentLi).find('.user-school-info-faculty').val(groupInfo['facultyName']);
        }
    });
}

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
