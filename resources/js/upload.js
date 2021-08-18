var fileTypes = ['pdf', 'docx', 'rtf', 'jpeg', 'png', 'txt'];

$("#up").change(function () {
    if (this.files && this.files[0]) {
        var extension = this.files[0].name.split('.').pop().toLowerCase(),
            isSuccess = fileTypes.indexOf(extension) > -1;
        if (isSuccess) {
            var reader = new FileReader();
            reader.onload = function (e) {
                switch (extension) {
                    case 'pdf':
                        $("#up").closest('.fileUpload').find(".icon").attr('src', 'images/web/file_pdf.svg');
                        break;
                    case 'docx':
                        $("#up").closest('.fileUpload').find(".icon").attr('src', 'images/web/file_doc.svg');
                        break;
                    case 'rtf':
                        $("#up").closest('.fileUpload').find(".icon").attr('src', 'images/web/file_rtf.svg');
                        break;
                    case 'png':
                        $("#up").closest('.fileUpload').find(".icon").attr('src', 'images/web/file_png.svg');
                        break;
                    case 'jpeg':
                        $("#up").closest('.fileUpload').find(".icon").attr('src', 'images/web/file_jpg.svg');
                        break;
                    case 'txt':
                        $("#up").closest('.fileUpload').find(".icon").attr('src', 'images/web/file_txt.svg');
                        break;
                    default:
                        $("#up").closest('.uploadDoc').find(".docErr").fadeIn();
                        break;
                }
            }
            reader.readAsDataURL(this.files[0]);
        } else {
            this.value = '';
            $("#up").closest('.uploadDoc').find(".docErr").fadeIn();
            setTimeout(function () {
                $('.docErr').fadeOut('slow');
            }, 3000);
        }
    }
})

$(document).on('change', '#up', function () {
    var id = $(this).attr('id');
    var profilePicValue = $(this).val();
    var fileNameStart = profilePicValue.lastIndexOf('\\');
    profilePicValue = profilePicValue.substr(fileNameStart + 1).substring(0, 20);
    if (profilePicValue != '') {
        $(this).closest('.fileUpload').find('.upl').html(profilePicValue);
    }
});

$(".close").click(function () {
    $(".alert").slideUp();
});

$(".select-category").select2({
    tags: true
});
