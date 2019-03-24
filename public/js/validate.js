function validateInput(input, msg, allowed) {
    if (allowed == "letters") {reMsg="Only letters from a-Å allowed"; re = /^[A-Za-zÀ-ÿ ]+$/}
    if (allowed == "email") {reMsg="Invalid email"; re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/}
    if ($(input).val() == "") {
        errorMsg(input, msg);
        return false;
    } else if (allowed !== "all" && !re.test($(input).val())) {
        errorMsg(input, reMsg);
        return false;
    } else {
        if ($(input+"Alert").length) {
            $(input+"Alert").remove();
            $(input).removeClass('border-danger');
        }
        return true;
    }
}
function validateUsername(input, id) {

    var username = $(input).val();
    var id = $(id).val();

    $.ajax({
        type: 'get',
        url: '../assets/ajax/checkUserEmail.php?u='+username+'&id='+id+'',
        success: function (res) {
            console.log(res);
            var message = jQuery.parseJSON(res);
            var status = message.status;
            var msg = message.output;
            if (status == "error") {
                errorMsg(input, msg);
                $('#ePSubmit').attr('disabled', 'disabled');
            } else {
                $('#ePSubmit').removeAttr('disabled');
            }
        }
    });
}
function validatePasswords(input, input2, msg, msgAlike) {
    input1Val = $(input).val();
    input2Val = $(input2).val();
    if ($(input).val() == "") {
        errorMsg(input, msg);
        return false;
    }
    if ($(input2).val() == "") {
        errorMsg(input2, msg);
        return false;
    }
    if (input1Val !== input2Val) {
        errorMsg(input2, msgAlike);
        return false;
    } else {
        if ($(input2+"Alert").length) {
            $(input2+"Alert").remove();
            $(input2).removeClass('border-danger');
        }
        return true;
    }
}
function validateLogin(form, username, password, url) {
    usernameVal = $(username).val();
    passwordVal = $(password).val();

    $(function () {
        $.ajax({
            type: 'post',
            url: url,
            data: $(form).serialize(),
            success: function (res) {
                var message = jQuery.parseJSON(res);
                var status = message.status;
                var msg = message.output;

                if (status == "success") {
                    $.ajax({
                        type:"post",
                        data: $(form).serialize(),
                        url: "assets/ajax/initLogin.php",
                        success: function(data)
                        {
                            location.reload();
                        }
                    });   
                }
                else if (status == "error") 
                {
                    $('#form-loading').hide();
                    $('#formLogin').show();
                    errorMsg(password, msg);
                }
            }
        });
    });
}
function errorMsg(input, msg) {
    id = input.replace('#','');
    if($(input+"Alert").after().length) {
    } else {
        $(input).after('<span style="visibility:visible" class="mdl-textfield__error" id="'+ id +'Alert" style="color:red;margin-top:-35px"> '+ msg + ' </span>');
        $(input).addClass('border-danger');
    }
    $(input).keydown( function(){
        $(input+"Alert").remove();
        $(input).removeClass('border-danger');
    });
}