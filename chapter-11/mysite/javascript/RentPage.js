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
				required: ss.i18n.sprintf(
					ss.i18n._t('VALIDATION.Required'),
					ss.i18n._t('VALIDATION.Datetime_Field')
				)
			},
			FirstName: {
				required: ss.i18n.sprintf(
					ss.i18n._t('VALIDATION.Required'),
					ss.i18n._t('VALIDATION.Firstname_Field')
				)
			},
			Surname: {
				required: ss.i18n.sprintf(
					ss.i18n._t('VALIDATION.Required'),
					ss.i18n._t('VALIDATION.Surname_Field')
				)
			},
			Email: {
				required: ss.i18n.sprintf(
					ss.i18n._t('VALIDATION.Required'),
					ss.i18n._t('VALIDATION.Email_Field')
				),
				email: ss.i18n._t('VALIDATION.Email')
			},
			Phone: {
				required: ss.i18n.sprintf(
					ss.i18n._t('VALIDATION.Required'),
					ss.i18n._t('VALIDATION.Phone_Field')
				),
				digits: ss.i18n.sprintf(
					ss.i18n._t('VALIDATION.Digits'),
					ss.i18n._t('VALIDATION.Phone_Field')
				),
				range: ss.i18n.sprintf(
					ss.i18n._t('VALIDATION.Range_Digits'),
					ss.i18n._t('VALIDATION.Phone_Field'),
					6,
					15
				)
			},
			Count: {
				required: ss.i18n.sprintf(
					ss.i18n._t('VALIDATION.Required'),
					ss.i18n._t('VALIDATION.People_Field')
				),
				digits: ss.i18n.sprintf(
					ss.i18n._t('VALIDATION.Digits'),
					ss.i18n._t('VALIDATION.People_Field')
				),
				range: ss.i18n.sprintf(
					ss.i18n._t('VALIDATION.Range_Numbers'),
					ss.i18n._t('VALIDATION.People_Field'),
					1,
					100
				)
			}
		}
	});
});