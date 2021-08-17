$(function () {
    var urlData = $('#documentData').val();
    var restoreName = $('#restore').html();
    var coverName = $('#cover').html();
    var deleteName = $('#delete').html();
    $('#documentTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: urlData,
        columns: [
            { data: 'Number', name: 'Number' },
            { data: coverName, name: coverName },
            { data: 'name', name: 'name' },
            { data: 'category.name', name: 'category.name', defaultContent: "Root" },
            { data: 'upload_by.name', name: 'upload_by.name' },
            { data: 'deleted_at', name: 'deleted_at', defaultContent: "" },
            { data: restoreName, name: restoreName },
            { data: deleteName, name: deleteName },
        ]
    });
});
