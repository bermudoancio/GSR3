$().ready(function(){
    $("form[name=form]").on('submit', function(){
        return confirm(mensajes.ejecutarAccion)
    });
});