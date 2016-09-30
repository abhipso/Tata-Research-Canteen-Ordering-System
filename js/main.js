

if (document.forms.login.username.value==='') {
	document.forms.login.username.focus();
}
else if (document.forms.login.password.value==='') {
		document.forms.login.password.focus();
}

function validate()
{
	if (document.forms.login.username.value===''&&document.forms.login.password.value==='') {
			$(function() {
	$('#no_username').show('300').delay('2000').hide('50');
	$('#no_password').show('300').delay('2000').hide('50');

	});
	return false;
	}
	if (document.forms.login.username.value==='') {
	$(function() {
	$('#no_username').show('300').delay('2000').hide('50');
	});
	return false;
	}
	if (document.forms.login.password.value==='') {
		$(function() {
	$('#no_password').show('300').delay('2000').hide('50');
	});
	return false;
	}

	
	return true;
}

function invalidlogin() 
{
	$(function() {
	$('#invalid_login').show('300').delay('20000').hide('50');

	});
}
