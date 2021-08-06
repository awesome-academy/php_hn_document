$('#users-table').on('click', '.btn-ban[data-remote]', function (e) {
    e.preventDefault();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var url = $(this).data('remote');
    $.ajax({
        url: url,
        type: 'POST',
        dataType: 'json',
        data: { method: '_POST', submit: true }
    }).always(function (data) {
        $('#users-table').DataTable().draw(true);
    });
})
    .on('click', '.btn-upgrade[data-remote]', function (e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var url = $(this).data('remote');
        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            data: { method: '_POST', submit: true }
        }).always(function (data) {
            $('#users-table').DataTable().draw(true);
        });
    });
