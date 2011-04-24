<?php


/**
 * Provide site wide fields in the CMS.
 *
 * @package mysite
 */
class CustomSiteConfig extends DataObjectDecorator {


	/**
	 * Adding the site specific fields.
	 *
	 * @return array Array of arrays with all necessary database fields.
	 */
	public function extraStatics(){
		return array(
			'db' => array(
				'Phone' => 'Varchar(64)',
				'Address' => 'Varchar(64)',
				'Email' => 'Varchar(64)',
				'OpeningHours' => 'HTMLText',
			)
		);
	}


	/**
	 * The CMS fields to add and remove on the sitewide configuration page.
	 *
	 * @param &$fielsd FieldSet Base fields to extend.
	 * @return FieldSet Base fields plus newly included fields.
	 */
	public function updateCMSFields(FieldSet &$fields){
		$fields->addFieldToTab('Root.Main', new TextField('Phone', 'Phone number'));
		$fields->addFieldToTab('Root.Main', new TextField('Address'));
		$fields->addFieldToTab('Root.Main', new TextField('Email', 'Email contact address'));
		$fields->addFieldToTab('Root.Main', new HTMLEditorField('OpeningHours'));
		$fields->removeFieldFromTab('Root.Main', 'Title');
		$fields->removeFieldFromTab('Root.Main', 'Tagline');
	}


}