$(document).ready(function(){
	$("#Form_Form").validate({
		rules: {
			FirstName: {
				required: true
			},
			Surname: {
				required: true
			},
			Email: {
				required: true,
				email: true
			},
			Phone: {
				digits: true
			},
			Comment: {
				required: true
			}
		},
		messages: {
			FirstName: {
				required: "The first name is required"
			},
			Surname: {
				required: "The surname is required"
			},
			Email: {
				required: "The email address is required",
				email: "Please provide a valid email address"
			},
			Phone: {
				digits: "The phone number must only consist of numbers"
			},
			Comment: {
				required: "Please provide a text for your message"
			}
		}
	});
});