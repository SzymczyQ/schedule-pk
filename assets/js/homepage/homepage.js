$('.schedule-data-table').DataTable({
    'paging'      : true,
    'lengthChange': true,
    'searching'   : true,
    'ordering'    : true,
    'info'        : true,
    'autoWidth'   : false,
    'responsive'  : true,
    'scrollX'     : true,
    'language': {
        'url': '//cdn.datatables.net/plug-ins/1.10.19/i18n/Polish.json'
    },
    dom: 'Bfrtip',
    buttons: [
        'csv', 'pdf'
    ]
});