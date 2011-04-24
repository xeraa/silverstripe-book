$(document).ready(function(){
	$("#Form_Form").validate({
		rules: {
			Datetime: {
				required: true
			},
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
				required: true,
				digits: true,
				range: [100000, 1000000000000000]
			},
			Count: {
				required: true,
				digits: true,
				range: [1, 100]
			}
		},
		messages: {
			Datetime: {
				required: "Date and time are required"
			},
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
				required: "The phone number is required",
				digits: "The phone number must only consist of numbers",
				range: "The phone number must have between 6 and 15 digits"
			},
			Count: {
				required: "The number of people is required",
				digits: "The number of people must only consist of numbers",
				range: "The number of people must be between 1 and 100"
			}
		}
	});
});