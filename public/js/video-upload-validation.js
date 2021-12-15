let errorMessages;
let counterOnLoad;
function validate_videos(evt, callback) {
    errorMessages = '';
    counterOnLoad = 0;
    let files = evt.target.files;
    for(let i = 0; i < files.length; i++) {
        let file = evt.target.files[i];
        let fileType = file.type;
        let image_size = (file.size / 6291456000).toFixed(3);
        let validImageTypes = ["video/mp4",];

        if ($.inArray(fileType, validImageTypes) < 0) {
            //  Please follow the required types (.jpeg, .png)
            errorMessages += file.name + ' invalid file type.</br>';
            // $('#errorMessage').html(file.name + ' invalid file type.');
            // $('#toastDynamicError').toast('show');
            if (errorMessages !== '' && i+1 >= files.length && counterOnLoad == 0) {
                show_error_messages();
            }
            continue;
        }
        if (image_size > 6000) {
            //  The maximum file size is 6 GB.
            errorMessages += file.name + '  exceeded the maximum file size.</br>';
            // $('#errorMessage').html(file.name + '  exceeded the maximum file size.');
            // $('#toastDynamicError').toast('show');
            if (errorMessages !== '' && i+1 >= files.length && counterOnLoad == 0) {
                show_error_messages();
            }
            continue;
        }
        counterOnLoad = 1;

        callback(file);

        if (errorMessages !== '') {
            show_error_messages();
        }
    }
}

function validate_images(evt, callback) {
    errorMessages = '';
    counterOnLoad = 0;
    let files = evt.target.files;
    for(let i = 0; i < files.length; i++) {
        let file = evt.target.files[i];
        let fileType = file.type;
        let image_size = (file.size / 2097152).toFixed(3);
        let validImageTypes = ["image/jpeg", "image/png"];

        if ($.inArray(fileType, validImageTypes) < 0) {
            errorMessages += file.name + ' invalid file type.</br>';
            if (errorMessages !== '' && i+1 >= files.length && counterOnLoad == 0) {
                show_error_messages();
            }
            continue;
        }
        if (image_size > 2) {
            //  The maximum file size is 2 MB.
            errorMessages += file.name + '  exceeded the maximum file size.</br>';
            if (errorMessages !== '' && i+1 >= files.length && counterOnLoad == 0) {
                show_error_messages();
            }
            continue;
        }
        counterOnLoad = 1;
        let img = new Image;
        img.onload = function () {
            if (img.width != THUMBNAIL_WIDTH || img.height != THUMBNAIL_HEIGHT) {
                errorMessages += file.name + ' has invalid dimensions.</br>';
            } else {
                callback(file);
            }

            if (errorMessages !== '') {
                show_error_messages();
            }
        };
        img.src = window.URL.createObjectURL(file);
    }
}

function show_error_messages()
{
    $('#toastDynamicError').toast('dispose');
    $('#errorMessage').html(errorMessages);
    $('#toastDynamicError').toast('show');
}
