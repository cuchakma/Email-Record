let clicksubmit = document.getElementById('submit');
clicksubmit.addEventListener('click', Roles);

function Roles(event) {
	event.preventDefault();
	let options = document.querySelector('fieldset').elements;
	let selected_roles = [];
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
			alert('Settings Saved Sucessfully');
		}else {
			return;
		}
	});
}
