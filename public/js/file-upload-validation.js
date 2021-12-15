let errorMessages;
let counterOnLoad;

function show_error_messages(errorFunction)
{
    $('#bannerErrorMessage').html(errorMessages);
    $('#prompt-banner-error').modal('show');

    errorFunction();
}

function functionAfterError() { }

function isImage(file){
    return file['type'].split('/')[0]=='image'; //returns true or false
}

function validate_files(files, callback, maxFileSize = 0, validTypes = [], imageRequiredWidth = 0, imageRequiredHeight = 0, errorFunction = functionAfterError()) {
    errorMessages = '';
    counterOnLoad = 0;

    for(let i = 0; i < files.length; i++) {
        let file = files[i];
        let fileType = file.type;
        let image_size = file.size/1024/1024; // For MB

        if (validTypes.length > 0 && $.inArray(fileType, validTypes) < 0) {
            errorMessages += file.name + ' invalid file type.</br>';
            if (errorMessages !== '' && i+1 >= files.length && counterOnLoad == 0) {
                show_error_messages(errorFunction);
            }
            continue;
        }
        if (maxFileSize > 0 && image_size > maxFileSize) {
            errorMessages += file.name + ' exceeded the maximum file size.</br>';
            if (errorMessages !== '' && i+1 >= files.length && counterOnLoad == 0) {
                show_error_messages(errorFunction);
            }
            continue;
        }
        counterOnLoad = 1;

        if (isImage(file) && (imageRequiredWidth != 0 || imageRequiredHeight != 0)) {
            let img = new Image;
            img.onload = function () {
                if (img.width != imageRequiredWidth || img.height != imageRequiredHeight) {
                    errorMessages += file.name + ' has invalid dimensions.</br>';
                }
                else {
                    callback(file);
                }

                if (errorMessages !== '') {
                    show_error_messages(errorFunction);
                }
            };
            img.src = window.URL.createObjectURL(file);
        } else {
            callback(file);

            if (errorMessages !== '') {
                show_error_messages(errorFunction);
            }
        }
    }
}
