<?php


/**
 * Defining the custom item of this page type.
 */
define('EMAILER_ICON_PATH', PROJECT_DIR . '/icons/mail');


/**
 * Base page for all contact forms.
 *
 * @package mysite
 */
class Emailer extends Page {


	/**
	 * Define receiver and thank you message.
	 */
	public static $db = array(
		'Mailto' => 'Varchar(100)',
		'SubmitText' => 'HTMLText',
	);


	/**
	 * Add a custom icon for easier recognition.
	 */
	public static $icon = EMAILER_ICON_PATH;


	/**
	 * Make the fields available in the CMS.
	 *
	 * @return FieldSet The added CMS fields.
	 */
	public function getCMSFields(){
		$fields = parent::getCMSFields();
		$fields->addFieldToTab("Root.Content.Email", new EmailField('Mailto', 'Recipient'));
		$fields->addFieldToTab("Root.Content.Email", new HTMLEditorField('SubmitText', 'Text after sending the message'));
		return $fields;
	}


}



/**
 * Base Controller for sending emails, to be extended by the child classes.
 *
 * @package mysite
 */
abstract class Emailer_Controller extends Page_Controller {


	/**
	 * Functions exposed via their URL.
	 */
	public static $allowed_actions = array(
		'sent',
	);


	/**
	 * Provide a default email subject.
	 */
	protected $subject = "Email Form Bar";


	/**
	 * Initialize JS for client side validation.
	 */
	public function init(){
		parent::init();
		Requirements::javascript(PROJECT_DIR . '/thirdparty/validate/jquery.validate.pack.js');
		define('SPAN', '<span class="required">*</span>');
	}


	/**
	 * The form itself, to be implemented by the child classes.
	 */
	abstract protected function Form();


	/**
	 * The form handler.
	 */
	public function sendemail($data, $form){
		if(!empty($this->Mailto)){
			$email = $this->Mailto;
		} else {
			$email = EMAIL;
		}

		$from = $data['Email'];
		$to = $email;
		$subject = $this->subject;
		$email = new Email($from, $to, $subject);
		$email->setTemplate('Email');
		$email->populateTemplate($data);
		$email->send();

		Director::redirect($this->Link('sent'));
	}


	/**
	 * Provide a page for displaying a message after sending an email.
	 */
	public function sent(){
		return array();
	}


	/**
	 * Thank you message.
	 *
	 * @return boolean Tell the template if this URL parameter is set or not.
	 */
	protected function IsSuccess(){
		$url = Director::URLParams();
		return (isset($url['Action']) && ($url['Action'] == 'sent'));
	}


}