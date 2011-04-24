<?php


/**
 * Defining the custom item of this page type.
 */
define('CONTENT_ICON_PATH', PROJECT_DIR . '/icons/content');



/**
 * Definining the custom content page.
 *
 * @package mysite
 */
class ContentPage extends Page {


	/**
	 * Remove unused page types in ancestors.
	 */
	public static $hide_ancestor = 'Page';


	/**
	 * Add a custom icon for easier recognition.
	 */
	public static $icon = CONTENT_ICON_PATH;


}



/**
 * Controller for the custom content page.
 *
 * @package mysite
 */
class ContentPage_Controller extends Page_Controller {


	/**
	 * Functions exposed via their URL.
	 */
	public static $allowed_actions = array();


}