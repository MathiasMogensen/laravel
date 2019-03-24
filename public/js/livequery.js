// PARAMETERS:
// form = the form to check for submit
// load = the html element refresh after query. Set to false to use same value as form
// url = the php file with query

livequery = function(form, load, url) {
    $(function () {

        $.ajax({
            type: 'post',
            url: url,
            data: $(form).serialize(),
            success: function (res) {
                console.log(res);
                var message = jQuery.parseJSON(res);
                var status = message.status;
                var msg = message.output;
                if (status == "success") {
                    if(load == false) {
                    } else {
                        $(load).load(location.href+" "+ load +">*","");
                    }
                    alertMessage(msg);
                }
                else if (status == "error") {
                    load.reload();
                    alertMessage(msg);
                }
            }
        });
    });
};

function tableSubmit(form, url) {

    $('#table-content').hide();
    $('#pagination-links').hide();
    $('#table-loading').show();

    $(function () {

        $.ajax({
            type: 'post',
            url: 'assets/ajax/'+url+'.php',
            data: $(form).serialize(),
            success: function (res) {
                console.log(res);
                var message = jQuery.parseJSON(res);
                var status = message.status;
                var msg = message.output;
                if (status == "success") {
                    $(form).load(location.href+" "+ form +">*","", function(){
                        $.getScript("assets/js/material/checkall.js");
                        $('#table-content').show();
                        $('#pagination-links').show();
                        $('#table-loading').hide();
                        alertMessage(msg);
                    });
                }
                else if (status == "error") {
                    alertMessage(msg);
                    $('#table-content').show();
                    $('#pagination-links').show();
                    $('#table-loading').hide();
                }
            }
        });
    });
};


function formSubmit(form, id, url) {

    $('#form-edit').hide();
    $('#form-loading').show();

    $(function () {

        $.ajax({
            type: 'post',
            url: 'assets/ajax/'+url+'.php',
            data: $(form).serialize(),
            success: function (res) {
                console.log(res);
                var message = jQuery.parseJSON(res);
                var status = message.status;
                var msg = message.output;
                if (status == "success") {
                    $(form).load(location.href+" "+ form +">*","", function(){
                        $('#form-loading').hide();
                        $('#form-edit').show();
                        alertMessage(msg);
                    });
                }
                else if (status == "error") {
                    $('#form-loading').hide();
                    $('#form-edit').show();
                    alertMessage(msg);
                }
            }
        });
    });
};

function alertMessage(msg) {
    var notification = document.querySelector('.mdl-js-snackbar');
    var button = document.querySelector('.mdl-snackbar__action');
    notification.MaterialSnackbar.showSnackbar(
        {
            message: msg,
            timeout: 5000,
            actionHandler: button,
            actionText: 'Ok'
        }
    );
    button.addEventListener('click', function() {
        notification.MaterialSnackbar.cleanup_();
    });
}