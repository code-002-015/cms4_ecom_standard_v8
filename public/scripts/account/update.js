
$(document).on('click','.delete_user', function(){
    $('#modalUserDelete').show();

    $('#user_id').val($(this).data('user_id'));
});


// displays form error validation
function printErrorMsg (msg) {
    $(".print-error-msg").find("ul").html('');
    $(".print-error-msg").css('display','block');
    $.each( msg, function( key, value ) {
        $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
    });
}
// end

// Ajax change password validation
$(document).ready(function(){
    $('.pass_show').append('<span class="ptxt">Show</span>');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});

$(document).on('click','.pass_show .ptxt', function(){ 
    $(this).text($(this).text() == "Show" ? "Hide" : "Show"); 
    $(this).prev().attr('type', function(index, attr){
        return attr == 'password' ? 'text' : 'password'; 
    }); 
});

$(document).on('click','.change_pass', function(e){
    e.preventDefault();

    var _token   = $("input[name='_token']").val();
    var new_pass = $("input[name='new_password']").val();
    var con_pass = $("input[name='confirm_password']").val();
    var cur_pass = $("input[name='current_password']").val();
    var uid      = $("input[name='uid']").val();

    $.ajax({
        url: '/update_password',
        method: 'post',
        data: {
            _token : _token, new_password : new_pass, confirm_password : con_pass, current_password : cur_pass, user_id : uid,
        },
        success: function(data){
            if($.isEmptyObject(data.error)){
                window.location.href = '/password_changed';
            }else{
                printErrorMsg(data.error);
            }
        }
    });
});
// end 

// Ajax avatar/file validation & upload avatar 
$("body").on("click",".upload-avatar",function(e){
    $(this).parents("form").ajaxForm(options);
});

var options = { 
    complete: function(response) 
    {
        if($.isEmptyObject(response.responseJSON.error)){
            sessionStorage.reloadAfterPageLoad = 'Avatar successfully changed';
            window.location.reload();
        }else{
            printErrorMsg(response.responseJSON.error);
        }
    }
};  

$(function(){
    if ( sessionStorage.reloadAfterPageLoad ) {
        $('#toast_successs').toast('show');
        $('#a_msg').html(sessionStorage.reloadAfterPageLoad);
        sessionStorage.clear();
    }
});
// end ajax file upload and validation
