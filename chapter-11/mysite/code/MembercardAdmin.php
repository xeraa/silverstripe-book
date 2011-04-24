<?php


/**
 * Allow easy manipulation of Membercard entries in the backend.
 */
class MembercardAdmin extends ModelAdmin {


	/**
	 * Define which models to manage.
	 */
	public static $managed_models = array(
		'Member',
	);


	/**
	 * Define the URL of the admin model - below /admin/.
	 */
	public static $url_segment = 'membercard';


	/**
	 * Define the name in the CMS top menu.
	 */
	public static $menu_title = 'Membercard';


	/**
	 * Register our custom collection controller.
	 */
	public static $collection_controller_class = 'MembercardAdmin_CollectionController';


}



/**
 * Custom collection for fetching only a subset of all available member objects - defined in getSearchQuery().
 */
class MembercardAdmin_CollectionController extends ModelAdmin_CollectionController {


	/**
	 * Only fetch people from the "Members" group, not admins and content authors.
	 *
	 * @return SearchQuery The search query including our custom settings.
	 */
	public function getSearchQuery($searchCriteria){
		$group = DataObject::get_one('Group', "\"Code\" = 'members'");
		if($group){
			$groupId = (int)$group->ID;
		} else {
			$groupId = 0;
		}
		$query = parent::getSearchQuery($searchCriteria);
		$query->from(', "Group_Members"');
		$query->where('"Member"."ID" = "Group_Members"."MemberID" AND "Group_Members"."GroupID" = ' . $groupId);
		$query->orderby('"MustCreateCard" DESC, "Created" ASC');
		return $query;
	}


}