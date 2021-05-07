let clicksubmit = document.getElementById('submit');
clicksubmit.addEventListener('click', Roles);

function Roles(event) {
	event.preventDefault();
	var div  = document.createElement('div');
	var div2 = document.createElement('div');
	var div3 = document.createElement('div');
	var p    = document.createElement('p');
	div3.className = 'notice notice-success is-dismissible';
	p.innerText += "Settings Saved";
	div3.appendChild(p);
	div.className = 'loading';
	div2.className = 'loader'
	div.appendChild(div2);
	var screen = document.getElementById('wpwrap');
	screen.appendChild(div);
	var hide = document.querySelector('div');
	var child = hide.lastChild
	var options = document.querySelector('fieldset').elements;
	var selected_roles = [];
	for( let i = 0; i < options.length; i++ ) {
		if( options[i].checked  == true && options[i].value!== 'administrator') {
			selected_roles[i] =  options[i].value;
		}
	}
	selected_roles = selected_roles.filter(function (e) {return e != null;});
	fetch(addcapability.ajax_url,{
		method: 'POST',
		headers: {
			'Content-Type': 'application/x-www-form-urlencoded; charset=utf-8'
		},
		body : 'selected_roles='+selected_roles+'&action=add-capability&_wpnonce='+addcapability.nonce,
		credentials: 'same-origin'
	}).then(data => {
		if( data.status == 200 ) {
			setInterval( () => {child.remove()}, 2000 );
			var insert = document.getElementById('tab-1').querySelector('form');
			insert.insertAdjacentElement('afterbegin', div3);
			setInterval(() => {fadeout(div3)}, 3000);
		}else {
			return;
		}
	});
}

function fadeout(element) {

    var intervalID = setInterval(function () {
          
        if (!element.style.opacity) {
            element.style.opacity = 1;
        }
          
          
        if (element.style.opacity > 0) {
            element.style.opacity -= 0.1;
        } 
          
        else {
            clearInterval(intervalID);
        }
          
    }, 200);
}
