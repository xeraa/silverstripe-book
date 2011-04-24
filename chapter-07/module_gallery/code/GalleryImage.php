<?php


/**
 * Provide a container for our gallery images.
 *
 * @package mysite
 */
class GalleryImage extends CustomImage {


	/**
	 * Adding a title to our image.
	 */
	static $db = array(
		'Title' => 'Text',
	);


	/**
	 * Popup for editing a single image and its title.
	 *
	 * @return FieldSet The iframe for editing the image.
	 */
	public function getCMSFields(){
		return new FieldSet(
			new TextField('Title'),
			new FileIFrameField('BaseImage')
		);
	}


	/**
	 * Resize the current image and return it's URL - setting the width for landscape images and the height for portraits.
	 *
	 * @return String The URL of the resized image.
	 */
	public function ResizedBaseImage(){
		$image = $this->BaseImage();
		if($image->getOrientation() == 2){
			return $image->SetWidth(720)->URL;
		} else {
			return $image->SetHeight(719)->URL;
		}
	}


}