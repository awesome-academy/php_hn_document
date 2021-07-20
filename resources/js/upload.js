var fileTypes = ['pdf', 'docx', 'rtf', 'jpg', 'jpeg', 'png', 'txt'];
function readURL(input) {
    if (input.files && input.files[0]) {
        var extension = input.files[0].name.split('.').pop().toLowerCase(),
            isSuccess = fileTypes.indexOf(extension) > -1;
        if (isSuccess) {
            var reader = new FileReader();
            reader.onload = function (e) {
                switch (extension) {
                    case 'pdf':
                        $(input).closest('.fileUpload').find(".icon").attr('src', 'images/web/file_pdf.svg');
                        break;
                    case 'docx':
                        $(input).closest('.fileUpload').find(".icon").attr('src', 'images/web/file_doc.svg');
                        break;
                    case 'rtf':
                        $(input).closest('.fileUpload').find(".icon").attr('src', 'images/web/file_rtf.svg');
                        break;
                    case 'png':
                        $(input).closest('.fileUpload').find(".icon").attr('src', 'images/web/file_png.svg');
                        break;
                    case 'jpg':
                        $(input).closest('.fileUpload').find(".icon").attr('src', 'images/web/file_jpg.svg');
                        break;
                    case 'txt':
                        $(input).closest('.fileUpload').find(".icon").attr('src', 'images/web/file_txt.svg');
                        break;
                    default:
                        $(input).closest('.uploadDoc').find(".docErr").fadeIn();
                        break;
                }
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            input.value = '';
            $(input).closest('.uploadDoc').find(".docErr").fadeIn();
            setTimeout(function () {
                $('.docErr').fadeOut('slow');
            }, 3000);
        }
    }
}
