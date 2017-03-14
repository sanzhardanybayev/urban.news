$('input[name="role"]').change(function(){
    switch($(this).val()){
        case "moderator":
            $("#registration-form").attr('action','/user/register/moderator/');
            break;
        case "admin":
            $("#registration-form").attr('action','/user/register/admin/');
            break;
        default:
            $("#registration-form").attr('action','/user/register/');
            break;
    }
});