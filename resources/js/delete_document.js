function trans(key, replace = {}) {
    let translation = key.split('.').reduce((t, i) => t[i] || null, window.translations);

    for (var placeholder in replace) {
        translation = translation.replace(`:${placeholder}`, replace[placeholder]);
    }

    return translation;
}

$("#documentTable").on('click', '.btnDelete', function (e) {
    e.preventDefault();
    var currentRow = $(this).closest("tr");
    var id = currentRow.find("#dataId").text();
    var url = currentRow.find("#urlDelete").val();
    swal({
        title: trans('document.sure'),
        text: trans('document.sure_delete'),
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: trans('document.yes_delete'),
        cancelButtonText: trans('document.cancel'),
        closeOnConfirm: false,
        closeOnCancel: false
    },
        function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: url,
                    type: "POST",
                    data: {
                        "_method": 'POST',
                        id: id,
                    },
                    success: function (data) {
                        swal({
                            title: data.title,
                            text: data.message,
                            type: "success",
                            confirmButtonClass: "btn-success",
                            confirmButtonText: "OK",
                            closeOnConfirm: false,
                        })
                    },
                    error: function (data) {
                        swal({
                            title: data.title,
                            text: data.message,
                            type: "error",
                        });
                    }
                });

            } else {
                swal({
                    title: trans('document.ok'),
                    text: trans('document.data_not_change'),
                    type: "error",
                });
            }
        });
})
    .on('click', '.btnRestore', function (e) {
        e.preventDefault();
        var currentRow = $(this).closest("tr");
        var id = currentRow.find("#dataId").text();
        var url = currentRow.find("#urlRestore").val();
        swal({
            title: trans('document.sure'),
            text: trans('document.sure_restore'),
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-success",
            confirmButtonText: trans('document.yes_restore'),
            cancelButtonText: trans('document.cancel'),
            closeOnConfirm: false,
            closeOnCancel: false
        },
            function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: url,
                        type: "POST",
                        data: {
                            "_method": 'POST',
                            id: id,
                        },
                        success: function (data) {
                            swal({
                                title: data.title,
                                text: data.message,
                                type: "success",
                                confirmButtonClass: "btn-success",
                                confirmButtonText: trans('document.ok'),
                                closeOnConfirm: false,
                            })
                        },
                        error: function (data) {
                            swal({
                                title: data.title,
                                text: data.message,
                                type: "error",
                            });
                        }
                    });
                } else {
                    swal({
                        title: trans('document.ok'),
                        text: trans('document.data_not_change'),
                        type: "error",
                    });
                }
            });
    });
