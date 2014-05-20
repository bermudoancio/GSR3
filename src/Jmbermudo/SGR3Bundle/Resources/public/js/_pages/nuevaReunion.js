var $collectionHolder;

jQuery(document).ready(function() {
    // Get the ul that holds the collection of tags
    $collectionHolder = $('ul.prereservas');
    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find(':input').length);
    $('.add_link').on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();
        // add a new tag form (see next code block)
        addForm($collectionHolder);
    });
    
    $collectionHolder.find('li').each(function() {
        //Activamos el datepicker para este elemento
        $(this).datetimepicker();
        
        addFormDeleteLink($(this));
    });
});

function addForm($collectionHolder) {
    // Get the data-prototype explained earlier
    var prototype = $collectionHolder.data('prototype');
    // get the new index
    var index = $collectionHolder.data('index');
    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    var newForm = prototype.replace(/__op_name__/g, index);
    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);
    // Display the form in the page in an li, before the "Add a tag" link li
    var $newFormLi = $('<li class="col-lg-6"></li>').append(newForm);
        
    // add a delete link to the new form
    addFormDeleteLink($newFormLi);
    
    $collectionHolder.append($newFormLi);
    
    $($newFormLi).find(".datetimepicker").each(function(){
        if($(this).hasClass('date')){
            today = new Date();
            today.setDate(today.getDate()-1);
            $(this).datetimepicker({
                pickTime: false,
                language: locale,
                 minDate: today
            });
        }
        else if($(this).hasClass('time')){
            $(this).datetimepicker({
                pickDate: false,
                language: locale
            });
            
//            //Necesitamos enlazar los dos relojes para gestionar la hora inicio  
//            // y hora fin. Para ello, vemos si el elemento anterior es un time o no
//            if($(this).parent('.col-lg-6').prev().find(".datetimepicker").hasClass('time')) {
//                prev = $(this).prev().find(".datetimepicker.time");
//                //Estamos con la hora fin
//                $(this).on("dp.change", function(e) {
//                    prev.data("DateTimePicker").setMaxDate(e.date);
//                });
//            }
//            else{
//                //El siguiente elemento debe ser la hora máxima
//                next = $(this).next().find(".datetimepicker.time");
//                $(this).on("dp.change", function(e) {
//                    next.data("DateTimePicker").setMinDate(e.date);
//                });
//            }
        }
    });
}

function addFormDeleteLink($formLi) {
var $removeFormA = $('<a href="#" class="btn btn-warning"><i class="glyphicon glyphicon-trash"></i></a>');
    $formLi.append($removeFormA);
    $removeFormA.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();
        // remove the li for the tag form
        $formLi.remove();
    });
}