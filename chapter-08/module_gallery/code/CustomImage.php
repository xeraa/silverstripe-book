<?php


/**
 * Provide a container for our custom images.
 *
 * @package mysite
 */
class CustomImage extends DataObject {


	/**
	 * Our custom image class contains one image that is used on one page.
	 */
	public static $has_one = array (
		'BaseImage' => 'Image',
		'BelongToPage' => 'Page',
	);


	/**
	 * Popup for editing a single image.
	 *
	 * @return FieldSet The iframe for editing the image.
	 */
	public function getCMSFields(){
		return new FieldSet(
			new FileIFrameField('BaseImage')
		);
	}


}