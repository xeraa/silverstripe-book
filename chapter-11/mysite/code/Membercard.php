<?php


/**
 * Create a new membercard class.
 */
class Membercard extends DataObjectDecorator implements PermissionProvider {


	/**
	 * Adding member fields to the member class.
	 *
	 * @return array Array of arrays with all necessary database settings.
	 */
	public function extraStatics(){
		return array(
			'db' => array(
				'Sex' => "Enum('-, male, female', '-')",
				'Birth' => 'Date',
				'Address' => 'Varchar(64)',
				'Zip' => 'Int',
				'City' => 'Varchar(32)',
				'Phone' => 'Int',
				'MustCreateCard' => 'Boolean',
			),
			'searchable_fields' => array(
				'ID' => array(
					'field' => 'TextField',
					'filter' => 'PartialMatchFilter',
				),
				'FirstName',
				'Surname',
				'City',
				'Zip',
				'MustCreateCard',
			),
			'summary_fields' => array(
				'ID',
				'FirstName',
				'Surname',
				'Email',
				'MustCreateCard',
			),
		);
	}


	/**
	 * Set field specific form elements.
	 */
	public function updateCMSFields(&$fields){
		$fields->addFieldToTab('Root.Main', new TextField('FirstName', 'First name', '', 32), 'Surname');
		$fields->addFieldToTab('Root.Main', new TextField('Surname', 'Surname', '', 32), 'Birth');
		$fields->addFieldToTab('Root.Main', new TextField('Address', 'Address', '', 64), 'Zip');
		$fields->addFieldToTab('Root.Main', new TextField('City', 'City', '', 32), 'Phone');
		$fields->addFieldToTab('Root.Main', new EmailField('Email', 'Email', '', 64), 'MustCreateCard');
	}


	/**
	 * Centrally define the custom permission codes.
	 *
	 * @return array The associative array with the permission codes and their description.
	 */
	public function providePermissions(){
		return array(
			'MEMBER_EDITOR' => 'Create, edit and delete members',
		);
	}


	/**
	 * Set permissions for non-admin users.
	 *
	 * @return boolean Wheter or not the current user is allowed to do the specified action.
	 */
	public function canEdit($member = null){
		if(!$member){
			return false;
		}
		return Permission::checkMember($member, 'MEMBER_EDITOR');
	}
	public function canDelete($member = null){
		return $this->canEdit($member);
	}
	public function canCreate($member = null){
		return $this->canEdit($member);
	}
	public function canView($member = null){
		return $this->canEdit($member);
	}


	/**
	 * Ensure that our custom "Members" group exists, before saving one of its members.
	 */
	public function onBeforeWrite(){
		$group = MembercardPage_Controller::getMembersGroup();
		if(!$group){
			$group = new Group();
			$group->Code = MEMBERSCODE;
			$group->Title = 'Members';
			$group->write();
		}
		parent::onBeforeWrite();
		return;
	}


}