$(document).ready(function(){
    $("#checkall input").change(function() {
        var listaElementos = document.querySelectorAll('.check');
    
        for(var i=0, n=listaElementos.length; i<n; i++){
            var element = listaElementos[i];
    
            if($('#checkall input').is(":checked")) {
                element.MaterialCheckbox.check();
          }
          else {
                element.MaterialCheckbox.uncheck();
          }
        }
    
        if($('.check input:checked').length) {
            $('#table-delete_btn').show();
        }else{
            $('#table-delete_btn').hide();
        }
    });
    
    $('.check').change(function(){
        var listaElementos = document.querySelectorAll('.check');
    
        
    
        for(var i=0, n=listaElementos.length; i<n; i++){
            var element = listaElementos[i];
            if($('.check input:checked').length == $('.check input').length ) {
                document.querySelector('#checkall').MaterialCheckbox.check();
            }else{
                document.querySelector('#checkall').MaterialCheckbox.uncheck();
            }
        }
    
        if($('.check input:checked').length) {
            $('#table-delete_btn').show();
        }else{
            $('#table-delete_btn').hide();
        }
    });
});

