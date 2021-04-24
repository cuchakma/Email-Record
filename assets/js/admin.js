;(function($){
    $('table').on('click', 'a.submitdelete', function(event){
        event.preventDefault();
        if( confirm("Are you sure you want to delete?") == false ) {
            return;
        } 
        var id = $(this).attr("data-id");
        wp.ajax.post('email-delete-record', {
            
            id: id,
            _wpnonce:deleteobject.nonce
            
        })
        $(this).closest('tr').css('background-color', 'white').hide(400, function(){
            $(this).remove();
        });
       
    });
})(jQuery)