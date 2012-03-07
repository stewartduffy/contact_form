
function init() {

	//console.log("init");
	var feedback = document.getElementById('feedback');
	var name = document.getElementById('theName');
	var email = document.getElementById('email');
	var message = document.getElementById('message');
	var spam = document.getElementById('formSpam');
	var formSubmit = document.getElementById('form');
	
	formSubmit.onsubmit = function(e){
		if(validateForm()) return true;
		return false;
	}
	
	function validateForm() {
		
		feedback.style.display = "block";
		feedback.innerHTML = "";
		
		if( name && !validName(name.value) || name.value == "Name" )
		{
			name.focus();
			feedback.innerHTML = "<p>Please provide a valid name</p>";
			return false;
		}
		else if( email && !validEmail(email.value) )
		{
			email.focus();
			feedback.innerHTML = "<p>Please provide a valid email address</p>";
			return false;
		}
		else if( message && message.value.length == 0 || message.value == "Message" )
		{
			message.focus();
			feedback.innerHTML = "<p>Please provide a message</p>";
			return false;
		}
		else
		{
			feedback.innerHTML = "<p>Sending...</p>";
			return true;
		}
	}
	
	function validName(value) {
		if(value.length < 2) return false;
		var reg = /^[A-Z][A-Za-z\. \-]*$/;
		return reg.test(value);
	}
		
	function validEmail(value) {
		var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
		return reg.test(value);
	}
	
	function validPhoneNumber(value) {
		//basic test for 7-12 numbers
		var reg = /^[0-9]{7,12}$/;
		return reg.test(value);
	}

}

//window.onload = init;
init();

