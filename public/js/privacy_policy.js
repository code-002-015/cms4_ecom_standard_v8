function cookiesPolicyBar(){
    // Check cookie
    if ($.cookie('privacyPolicy') != "active") $('#privacy-policy').show();
    //Assign cookie on click
    $('#cookieAcceptBarConfirm').on('click',function(){
        $.cookie('privacyPolicy', 'active', { expires: 1 }); // cookie will expire in one day
        $('#privacy-policy').fadeOut();
    });
}

cookiesPolicyBar();
