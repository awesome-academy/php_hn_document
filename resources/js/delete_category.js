$("#categoryTable").on('click', '.btnDelete', function (e) {
    e.preventDefault();
    var currentRow = $(this).closest("tr");
    var id = currentRow.find("#dataId").text();
    var hasChildren = currentRow.find("#hasChildren").val();
    swal({
        title: "Are you sure?",
        text: "Do you really want to delete?",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel plx!",
        closeOnConfirm: false,
        closeOnCancel: false
    },
        function (isConfirm) {
            if (isConfirm) {
                if (hasChildren == '1') {
                    swal({
                        title: "You really sure?",
                        text: "The category has children, Do you want to delete?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Yes, delete it!",
                        cancelButtonText: "No, cancel plx!",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    },
                        function (isConfirm) {
                            if (isConfirm) {
                                $.ajax({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    url: '/admin/categories/' + id,
                                    type: "DELETE",
                                    data: {
                                        "_method": 'DELETE',
                                        category: id,
                                    },
                                    success: function (data) {
                                        swal({
                                            title: data.title,
                                            text: data.message,
                                            type: "success",
                                            confirmButtonClass: "btn-success",
                                            confirmButtonText: "OK",
                                            closeOnConfirm: false,
                                        });
                                        currentRow.remove();
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
                                    title: "OK!",
                                    text: "Your data wasn't changed",
                                    type: "error",
                                });
                            }
                        });
                } else {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: '/admin/categories/' + id,
                        type: "DELETE",
                        data: {
                            "_method": 'DELETE',
                            category: id,
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
                            currentRow.remove();
                        },
                        error: function (data) {
                            swal({
                                title: data.title,
                                text: data.message,
                                type: "error",
                            });
                        }
                    });
                }
            } else {
                swal({
                    title: "OK!",
                    text: "Your data wasn't changed",
                    type: "error",
                });
            }
        });
});
