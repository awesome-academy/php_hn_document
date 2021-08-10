$(function () {
    var urlData = $('#categoryData').val();
    var editName = $('#edit').html();
    var deleteName = $('#delete').html();
    $('#categoryTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: urlData,
        columns: [
            { data: 'Number', name: 'Number' },
            { data: 'name', name: 'name' },
            { data: 'parent.name', name: 'parent.name', defaultContent: "Root" },
            { data: 'created_at', name: 'created_at' },
            { data: 'updated_at', name: 'updated_at' },
            { data: editName, name: editName },
            { data: deleteName, name: deleteName },
        ]
    });
});
