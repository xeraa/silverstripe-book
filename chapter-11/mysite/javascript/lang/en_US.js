if(typeof(ss) == 'undefined' || typeof(ss.i18n) == 'undefined'){
	console.error('Class ss.i18n not defined');
} else {
	ss.i18n.addDictionary('en_US', {
		'VALIDATION.Required': '%s is required',
		'VALIDATION.Digits': '%s must only consist of numbers',
		'VALIDATION.Range_Digits': '%s must have between %s and %s digits',
		'VALIDATION.Range_Numbers': '%s must be between %s and %s',
		'VALIDATION.Email': 'Please provide a valid email address',
		'VALIDATION.Datetime_Field': 'The Date and time field',
		'VALIDATION.Firstname_Field': 'The first name',
		'VALIDATION.Surname_Field': 'The surname',
		'VALIDATION.Email_Field': 'The email address',
		'VALIDATION.Phone_Field': 'The phone number',
		'VALIDATION.People_Field': 'The number of people'
	});
}