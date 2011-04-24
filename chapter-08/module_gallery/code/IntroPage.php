<?php


/**
 * Defining the custom item of this page type.
 */
define('INTRO_ICON_PATH', MODULE_GALLERY_DIR . '/icons/intro');



/**
 * Intro page.
 *
 * @package mysite
 */
class IntroPage extends Page {


	/**
	 * Page to where users should be redirect from the intro.
	 */
	public static $has_one = array(
		'PageRedirect' => 'SiteTree',
	);


	/**
	 * Relation to all included images.
	 */
	public static $has_many = array(
		'CustomImages' => 'CustomImage',
	);


	/**
	 * Add a custom icon for easier recognition.
	 */
	public static $icon = INTRO_ICON_PATH;


	/**
	 * Unclutter the interface by removing unneeded tabs and fields, adding the image field.
	 *
	 * @return FieldSet Cleaned up tabs and fields.
	 */
	public function getCMSFields(){
		$images = new ImageDataObjectManager(
			$this,
			'CustomImages',
			'CustomImage',
			'BaseImage'
		);

		$fields = parent::getCMSFields();
		$fields->addFieldToTab('Root.Content.Main', $images);
		$fields->addFieldToTab('Root.Content.Main', new TreeDropdownField('PageRedirectID', 'Page to redirect to', 'SiteTree'));
		$fields->removeFieldFromTab('Root.Content.Main', 'Content');
		$fields->removeFieldFromTab('Root.Content', 'Widgets');
		return $fields;
	}


}



/**
 * Controller for the intro page.
 *
 * @package mysite
 */
class IntroPage_Controller extends Page_Controller {


	/**
	 * Functions exposed via their URL.
	 */
	public static $allowed_actions = array();


	/**
	 * Initialize JS image rotator.
	 */
	public function init(){
		parent::init();

		Requirements::javascript(THIRDPARTY_DIR . '/jquery/jquery-packed.js');
		Requirements::javascript(MODULE_GALLERY_DIR . '/javascript/rotator.js');
		Requirements::css(MODULE_GALLERY_DIR . '/css/rotator.css', 'screen,projection');
	}


}