
$(function() {
    $('.selectpicker').selectpicker();
});



$(document).on('click','.delete_user', function(){
    $('#modalUserDelete').show();

    $('#user_id').val($(this).data('user_id'));
});

$(document).on('click','.deactivate_user', function(){
    $('#modalUserDeactivate').show();

    $('#deactivate_user_id').val($(this).data('user_id'));
});

$(document).on('click','.activate_user', function(){
    $('#modalUserAactivate').show();

    $('#activate_user_id').val($(this).data('user_id'));
});

