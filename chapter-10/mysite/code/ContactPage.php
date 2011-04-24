<?php


/**
 * Page with contact information and contact form, based on the custom Emailer class.
 *
 * @package mysite
 */
class ContactPage extends Emailer {


	/**
	 * Remove unused page types in ancestors.
	 */
	public static $hide_ancestor = 'Emailer';


}



/**
 * Controller for the contact page.
 *
 * @package mysite
 */
class ContactPage_Controller extends Emailer_Controller {


	/**
	 * Default subject of the email.
	 */
	protected $subject = "Contact Form Bar";


	/**
	 * Setting up the form.
	 *
	 * @return Form The final frontend contact form.
	 */
	protected function Form(){
		Requirements::javascript(PROJECT_DIR . '/javascript/ContactPage.js');

		$firstName = new TextField('FirstName', 'First name' . SPAN);
		$firstName->addExtraClass('rounded');
		$surname = new TextField('Surname', 'Surname' . SPAN);
		$surname->addExtraClass('rounded');
		$email = new EmailField('Email', 'Email address' . SPAN);
		$email->addExtraClass('rounded');
		$phone = new TextField('Phone', 'Phone number'); // Don't use a PhoneNumberField, it will ignore addExtraClass
		$phone->addExtraClass('rounded');
		$comment = new TextareaField('Comment','Message' . SPAN);
		$comment->addExtraClass('rounded');
		$fields = new FieldSet(
			$firstName,
			$surname,
			$email,
			$phone,
			$comment
		);
		$send = new FormAction('sendemail', 'Send');
		$send->addExtraClass('rounded');
		$actions = new FieldSet(
			$send
		);
		$validator = new RequiredFields('Email', 'Comment', 'FirstName', 'Surname');
		return new Form($this, 'Form', $fields, $actions, $validator);
	}


}