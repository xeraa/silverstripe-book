<?php


/**
 * Page with contact contact form for renting a table, based on the custom Emailer class.
 *
 * @package mysite
 */
class RentPage extends Emailer {


	/**
	 * From which time on reservations are allowed and how many days in advance.
	 */
	public static $db = array(
		'OpeningHour' => 'Int',
		'ReservationAdvance' => 'Int',
	);


	/**
	 * Setting custom Information for the datepicker.
	 *
	 * @return FieldSet The added CMS fields.
	 */
	public function getCMSFields(){
		$fields = parent::getCMSFields();
		$fields->addFieldToTab('Root.Content.' . _t('RentPage.DATEPICKER', 'Datepicker'), new NumericField("OpeningHour", _t('RentPage.OPENING', 'Opening Hour (hour)', PR_MEDIUM, 'CMS text')));
		$fields->addFieldToTab('Root.Content.' . _t('RentPage.DATEPICKER', 'Datepicker'), new NumericField("ReservationAdvance", _t('RentPage.ADVANCE', 'How many days one can book in advance', PR_MEDIUM, 'CMS text')));
		return $fields;
	}


}



/**
 * Controller for renting a table.
 *
 * @package mysite
 */
class RentPage_Controller extends Emailer_Controller {


	/**
	 * Default subject of the email.
	 */
	protected $subject = "Reservation Form Bar";


	/**
	 * Setting up the form.
	 *
	 * @return Form The final frontend contact form.
	 */
	protected function Form(){

		/**
		 * Include CSS and JavaScript for a date and time handler.
		 */
		Requirements::css(PROJECT_DIR . '/thirdparty/anytime/anytimec.css', 'screen,projection');
		Requirements::javascript(PROJECT_DIR . '/thirdparty/anytime/anytimec.js');

		/**
		 * Set up the client side validation.
		 */
		Requirements::javascript(PROJECT_DIR . '/javascript/RentPage.js');
		Requirements::customScript('
			$(document).ready(function(){

				/**
				 * Reservations can only be made for today (before 12:00 a.m.) or tomorrow and $this->ReservationAdvance days in advance.
				 */
				var now = new Date();
				var start = new Date(now.getFullYear(), now.getMonth(), now.getDate()' . ((date('H') > 12) ? '+1' : '') . ', ' . $this->OpeningHour . ', 00, 00);
				var end = new Date(now.getFullYear(), now.getMonth(), now.getDate()+' . $this->ReservationAdvance . ', 23, 59, 59);

				$("#Form_Form_Datetime").AnyTime_picker({
					format: "' . _t('RentPage.JSDATE', '%Y-%m-%e %H:%i') . '",
					firstDOW: 1,
					dayAbbreviations: [
						"' . _t('Emailer.SUN', 'Sun') . '",
						"' . _t('Emailer.MON', 'Mon') . '",
						"' . _t('Emailer.TUE', 'Tue') . '",
						"' . _t('Emailer.WED', 'Wed') . '",
						"' . _t('Emailer.THU', 'Thu') . '",
						"' . _t('Emailer.FRI', 'Fri') . '",
						"' . _t('Emailer.SAT', 'Sat') . '"
					],
					monthAbbreviations: [
						"' . _t('Emailer.JAN', 'Jan') . '",
						"' . _t('Emailer.FEB', 'Feb') . '",
						"' . _t('Emailer.MAR', 'Mar') . '",
						"' . _t('Emailer.APR', 'Apr') . '",
						"' . _t('Emailer.MAY', 'May') . '",
						"' . _t('Emailer.JUN', 'Jun') . '",
						"' . _t('Emailer.JUL', 'Jul') . '",
						"' . _t('Emailer.AUG', 'Aug') . '",
						"' . _t('Emailer.SEP', 'Sep') . '",
						"' . _t('Emailer.OCT', 'Oct') . '",
						"' . _t('Emailer.NOV', 'Nov') . '",
						"' . _t('Emailer.DEC', 'Dec') . '"
					],
					labelTitle: "' . _t('Emailer.DATETIME', 'Select a Date and Time') . '",
					labelYear: "' . _t('Emailer.YEAR', 'Year') . '",
					labelMonth: "' . _t('Emailer.MONTH', 'Month') . '",
					labelDayOfMonth: "' . _t('Emailer.DAY', 'Day') . '",
					labelHour: "' . _t('Emailer.HOUR', 'Hour') . '",
					labelMinute: "' . _t('Emailer.MINUTE', 'Minute') . '",
					labelSecond: "' . _t('Emailer.SECOND', 'Second') . '",
					earliest: start,
					latest: end,
				});
			});
		');

		$datetime = new TextField(
			'Datetime',
			sprintf(
				_t(
					'RentPage.DATETIME_LABEL',
					"Date and time (until 12:00 a.m. for the same day, at most %s days in advance)<noscript><br/>Format: YYYY-MM-DD HH:MM</noscript>"
				),
				$this->ReservationAdvance
			) . SPAN
		); // Don't use a DatetimeField, it will ignore addExtraClass
		$datetime->addExtraClass('rounded');
		$firstName = new TextField('FirstName', _t('RentPage.FIRSTNAME_LABEL', 'First name') . SPAN);
		$firstName->addExtraClass('rounded');
		$surname = new TextField('Surname', _t('RentPage.SURNAME_LABEL', 'Surname') . SPAN);
		$surname->addExtraClass('rounded');
		$email = new EmailField('Email', _t('RentPage.EMAIL_LABEL', 'Email addresse') . SPAN);
		$email->addExtraClass('rounded');
		$phone = new TextField('Phone', _t('RentPage.PHONE_LABEL', 'Phone number') . SPAN); // Don't use a PhoneNumberField, it will ignore addExtraClass
		$phone->addExtraClass('rounded');
		$count = new TextField('Count', _t('RentPage.COUNT_LABEL', 'Number of people') . SPAN);
		$count->addExtraClass('rounded');
		$comment = new TextareaField('Comment', _t('RentPage.COMMENT_LABEL', 'Optional Comment'));
		$comment->addExtraClass('rounded');
		$fields = new FieldSet(
			$datetime,
			$firstName,
			$surname,
			$email,
			$phone,
			$count,
			$comment
		);
		$send = new FormAction('sendemail', _t('Emailer.SEND', 'Send'));
		$send->addExtraClass('rounded');
		$actions = new FieldSet(
			$send
		);
		$validator = new RequiredFields('Email', 'FirstName', 'Surname', 'Count', 'Datetime', 'Phone');
		return new Form($this, 'Form', $fields, $actions, $validator);
	}


	/**
	 * The form handler.
	 */
	public function sendemail($data, $form){
		if(($data['Count'] < 1) || ($data['Count'] > 100)){
			$form->addErrorMessage('Count', _t('RentPage.COUNT_ERROR', 'The number of people must be between 1 and 100, please correct your input'), 'error');
			Session::set('FormInfo.Form_Form.data', $data);
			Director::redirectBack();
			return;
		}
		Emailer_Controller::sendemail($data, $form);
	}


}