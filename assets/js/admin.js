const input = document.getElementById('sbd-search-input');
if( !! input ) {
    input.type = 'date';
}

const list_anchors = document.getElementById( 'the-list' ).querySelectorAll( 'tr td div span a' );
for( let anchor of list_anchors ) {
    if( anchor.className === 'submitdelete' ){
        anchor.addEventListener( 'click', sendData );
    }
}

function sendData( ev ) {
    ev.preventDefault();
    if( confirm( 'Are You Sure, You Want To Delete This Record?' ) == true ) {
        let id = this.dataset.id ;
        fetch(deleteobject.ajax_url,{
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded; charset=utf-8'
            },
            body : 'id='+id+'&action=email-delete-record&_wpnonce='+deleteobject.nonce,
            credentials: 'same-origin'
        })
        this.closest('tr').remove('hide');
        setInterval('location.reload()', 200);  
    } else{
        return;
    }
        
}
