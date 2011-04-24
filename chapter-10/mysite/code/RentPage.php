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
		$fields->addFieldToTab('Root.Content.Datepicker', new NumericField("OpeningHour", "Opening hour (hour)"));
		$fields->addFieldToTab('Root.Content.Datepicker', new NumericField("ReservationAdvance", "How many days one can book in advance"));
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
					format: "%Y-%m-%e %H:%i",
					firstDOW: 1,
					earliest: start,
					latest: end,
				});
			});
		');

		$datetime = new TextField(
			'Datetime',
			'Date and time (until 12:00 a.m. for the same day, at most ' . $this->ReservationAdvance . ' days in advance)' .
					'<noscript><br/>Format: YYYY-MM-DD HH:MM</noscript>' . SPAN
		); // Don't use a DatetimeField, it will ignore addExtraClass
		$datetime->addExtraClass('rounded');
		$firstName = new TextField('FirstName', 'First name' . SPAN);
		$firstName->addExtraClass('rounded');
		$surname = new TextField('Surname', 'Surname' . SPAN);
		$surname->addExtraClass('rounded');
		$email = new EmailField('Email', 'Email addresse' . SPAN);
		$email->addExtraClass('rounded');
		$phone = new TextField('Phone', 'Phone number' . SPAN); // Don't use a PhoneNumberField, it will ignore addExtraClass
		$phone->addExtraClass('rounded');
		$count = new TextField('Count', 'Number of people' . SPAN);
		$count->addExtraClass('rounded');
		$comment = new TextareaField('Comment','Optional Comment');
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
		$send = new FormAction('sendemail', 'Send');
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
			$form->addErrorMessage('Count', 'The number of people must be between 1 and 100, please correct your input', 'error');
			Session::set('FormInfo.Form_Form.data', $data);
			Director::redirectBack();
			return;
		}
		Emailer_Controller::sendemail($data, $form);
	}


}