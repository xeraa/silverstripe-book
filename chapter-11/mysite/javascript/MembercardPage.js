$(document).ready(function(){
	$("#Form_Form").validate({
		rules: {
			Sex: {
				required: true
			},
			FirstName: {
				required: true
			},
			Surname: {
				required: true
			},
			Birth: {
				required: true
			},
			Address: {
				required: true
			},
			Zip: {
				required: true,
				digits: true,
				range: [1000, 99999]
			},
			City: {
				required: true
			},
			Email: {
				required: true,
				email: true,
				remote: location.pathname + "checkemail"
			},
			Phone: {
				required: true,
				digits: true,
				range: [100000, 999999999999999]
			},
			Accept: {
				required: true
			}
		},
		messages: {
			Sex: {
				required: "The selection of a gender is required"
			},
			FirstName: {
				required: "The first name is required"
			},
			Surname: {
				required: "The surname is required"
			},
			Birth: {
				required: "The date of birth is required"
			},
			Address: {
				required: "The address is required"
			},
			Zip: {
				required: "The zip code is required",
				digits: "The zip code must only consist of numbers",
				range: "The zip code must have 4 or 5 digits"
			},
			City: {
				required: "The city is required"
			},
			Email: {
				required: "The email address is required",
				email: "Please provide a valid email address",
				remote: "The given email address already exists"
			},
			Phone: {
				required: "The phone number is required",
				digits: "The phone number must only consist of numbers",
				range: "The phone number must have between 6 and 15 digits"
			},
			Accept: {
				required: "You need to accept the terms for getting a member card"
			}
		}
	});

	/**
	 * Day of birth.
	 */
	var now = new Date();
	var start = new Date(now.getFullYear()-99, now.getMonth(), now.getDate());
	var end = new Date(now.getFullYear()-16, now.getMonth(), now.getDate());

	$("#Form_Form_Birth").AnyTime_picker({
		format: "%Y-%m-%e",
		firstDOW: 1,
		earliest: start,
		latest: end,
	});
});