<?php


/**
 * Page with all the details for getting a member card, based on the custom Emailer class.
 *
 * @package mysite
 */
class MembercardPage extends Emailer {
}



/**
 * Controller for the member card.
 *
 * @package mysite
 */
class MembercardPage_Controller extends Emailer_Controller {


	/**
	 * Default subject of the email.
	 */
	protected $subject = "Membercard Bar";


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
		Requirements::javascript(PROJECT_DIR . '/javascript/MembercardPage.js');

		/**
		 * Add the fields.
		 */
		$sex = new OptionsetField(
			'Sex',
			'Sex' . SPAN,
			array(
				'male' => 'Male',
				'female' => 'Female',
			), ''
		);
		$firstName = new TextField('FirstName', 'First name' . SPAN, '', 32);
		$firstName->addExtraClass('rounded');
		$surname = new TextField('Surname', 'Surname' . SPAN, '', 32);
		$surname->addExtraClass('rounded');
		$birth = new DateField('Birth', 'Date of birth<noscript><br/>Format: YYYY-MM-DD</noscript>' . SPAN);
		$birth->addExtraClass('rounded');
		$birth->setConfig('dateformat', 'yyyy-MM-dd');
		$birth->setConfig('min', '-100 years');
		$birth->setConfig('max', '-16 years');
		$address = new TextField('Address', 'Address' . SPAN, '', 64);
		$address->addExtraClass('rounded');
		$zip = new NumericField('Zip', 'Zip code' . SPAN);
		$zip->addExtraClass('rounded');
		$city = new TextField('City', 'City' . SPAN, '', 32);
		$city->addExtraClass('rounded');
		$email = new EmailField('Email', 'Email address' . SPAN, '', 32);
		$email->addExtraClass('rounded');
		$phone = new NumericField('Phone', 'Phone number' . SPAN); // Don't use a PhoneNumberField, it will ignore addExtraClass
		$phone->addExtraClass('rounded');
		$accept = new CheckboxField('Accept', 'Your data may be digitally processed and we may inform you about the latest news per mail' . SPAN);
		$fields = new FieldSet(
			$sex,
			$firstName,
			$surname,
			$birth,
			$address,
			$zip,
			$city,
			$email,
			$phone,
			$accept
		);
		$send = new FormAction('sendemail', 'Send');
		$send->addExtraClass('rounded');
		$actions = new FieldSet(
			$send
		);
		$validator = new RequiredFields(
			'Sex',
			'FirstName',
			'Surname',
			'Birth',
			'Address',
			'Zip',
			'City',
			'Email',
			'Phone',
			'Accept'
		);
		$form = new Form($this, 'Form', $fields, $actions, $validator);

		return $form;
	}


	/**
	 * The form handler.
	 */
	public function sendemail($data, $form){

		/**
		 * Validate the input on the server-side.
		 */
		$error = false;
		if(strlen($data['Zip']) < 4){
			$form->addErrorMessage('Zip', 'The zip code must at least have four digits', 'error');
			$error = true;
		}
		if(strlen($data['Zip']) > 5){
			$form->addErrorMessage('Zip', 'The zip code must at most have five digits', 'error');
			$error = true;
		}
		if(strlen($data['Phone']) < 6){
			$form->addErrorMessage('Phone', 'The phone number must at least have 6 digits', 'error');
			$error = true;
		}
		if(strlen($data['Phone']) > 15){
			$form->addErrorMessage('Phone', 'The phone number must at most have 15 digits', 'error');
			$error = true;
		}
		if($this->duplicateEmail($data['Email'])){
			$form->addErrorMessage('Email', 'The given email address <b>' . $data['Email'] . '</b> already exists', 'error');
			$error = true;
		}
		if($error){
			if($data['Zip'] == 0){
				$data['Zip'] = '';
			}
			if($data['Phone'] == 0){
				$data['Phone'] = '';
			}
			Session::set('FormInfo.Form_Form.data', $data);
			Director::redirectBack();
			return;
		}

		/**
		 * If no error has occured, save the data and send it via email.
		 */
		$membercard = new Membercard();
		$fields = array(
			'Sex',
			'FirstName',
			'Surname',
			'Birth',
			'Address',
			'Zip',
			'City',
			'Email',
			'Phone',
		);
		$form->saveInto($membercard, $fields);
		$membercard->CreateCard = true;
		$membercard->Birth = $data['Birth'];
		$membercard->write();
		Emailer_Controller::sendemail($data, $form);
	}


	/**
	 * Provide function for Ajax call to check email addresses.
	 *
	 * Do not return values, echo strings as they are then evaluated.
	 */
	public function checkemail(){
		if($this->duplicateEmail($this->request->getVar('Email'))){
			echo 'false';
		} else {
			echo 'true';
		}
	}


	/**
	 * Provide an internal helper function, used both for the Ajax call and the form handler.
	 *
	 * @return String The already existing email address or null.
	 */
	protected function duplicateEmail($email){
		$SQL_email = Convert::raw2sql($email);
		$membercard = DataObject::get_one('Membercard', "\"Email\" = '$SQL_email'");
		if($membercard){
			return true;
		} else {
			return false;
		}
	}


}