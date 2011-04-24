<?php


/**
 * Defining the custom item of this page type.
 */
define('INTRO_ICON_PATH', PROJECT_DIR . '/icons/intro');



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
	 * Add a custom icon for easier recognition.
	 */
	public static $icon = INTRO_ICON_PATH;


	/**
	 * Unclutter the interface by removing unneeded fields.
	 *
	 * @return FieldSet Cleaned up fields.
	 */
	public function getCMSFields(){
		$fields = parent::getCMSFields();
		$fields->addFieldToTab('Root.Content.Main', new TreeDropdownField('PageRedirectID', 'Page to redirect to', 'SiteTree'));
		$fields->removeFieldFromTab('Root.Content.Main', 'Content');
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

		Requirements::customScript("
			function theRotator(){
				$('#rotator ul li').css({opacity: 0.0});
				$('#rotator ul li:first').css({opacity: 1.0});
				setInterval('rotate()', 3000);
			}
			function rotate(){
				var current = ($('#rotator ul li.show') ? $('#rotator ul li.show') : $('#rotator ul li:first'));
				var next = ((current.next().length) ? ((current.next().hasClass('show')) ? $('#rotator ul li:first') : current.next()) : $('#rotator ul li:first'));
				next.css({opacity: 0.0}).addClass('show').animate({opacity: 1.0}, 1000);
				current.animate({opacity: 0.0}, 1000).removeClass('show');
			};
			$(document).ready(function(){
				theRotator();
				$('#rotator').fadeIn(1000);
				$('#rotator ul li').fadeIn(1000); /* Tweak for IE */
			});
		");
	}


}