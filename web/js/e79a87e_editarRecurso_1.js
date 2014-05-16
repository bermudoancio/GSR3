$("form[name='form']").on('submit', function(){
    return confirm(mensajes.eliminarRecurso);
});

$().ready(function(){
    alert(mensajes.eliminarRecurso);
});