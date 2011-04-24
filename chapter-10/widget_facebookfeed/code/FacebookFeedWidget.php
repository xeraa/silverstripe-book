<?php


/**
 * Defining the functionality of the Facebook Feed widget.
 *
 * @package widget_facebookfeed
 */
class FacebookFeedWidget extends Widget {


	/**
	 * Create the database fields for configuring the widget.
	 */
	public static $db = array(
		'Identifier' => 'Varchar(64)',
		'Limit' => 'Int',
	);


	/**
	 * Provide meaningful default values - not possible for the ID.
	 */
	public static $defaults = array(
		'Limit' => 1,
	);


	/**
	 * Provide title and description to be used in the CMS.
	 */
	public static $cmsTitle = 'Facebook Messages';
	public static $description = 'A list of the most recent Facebook messages';


	/**
	 * Make the widget's configuration fields available in the CMS.
	 *
	 * @return FieldSet The added CMS fields.
	 */
	public function getCMSFields(){
		return new FieldSet(
			new TextField('Identifier', 'Identifier of the Facebook account to display'),
			new NumericField('Limit', 'Maximum number of messages to display')
		);
	}


	/**
	 * Fetch the messages from Facebook and make them available to the template.
	 * The feed includes both your own posts and the ones from others. We are however only interested in our own posts, so we'll fetch some more and throw the others away.
	 * Taking five more might not be sufficient, but we'll assume it's enough for our scenario.
	 *
	 * @return DataObjectSet Array containing all relevant fields.
	 */
	public function Feeds(){

		/**
		 * URL for fetchning the information, convert the returned JSON into an array.
		 */
		$url = 'http://graph.facebook.com/' . $this->Identifier . '/feed?limit=' . ($this->Limit + 5);
		$facebook = json_decode(file_get_contents($url), true);

		/**
		 * Make sure we received some content, create a warning in case of an error.
		 */
		if(empty($facebook) || !isset($facebook['data'])){
			user_error('Facebook message error or API changed', E_USER_WARNING);
			return;
		}

		/**
		 * Iterate over all messages and only fetch as many as needed.
		 */
		$feeds = new DataObjectSet();
		$count = 0;
		foreach($facebook['data'] as $post){
			if($count >= $this->Limit){
				break;
			}

			/**
			 * If no such messages exist, log a warning and exit.
			 */
			if(!isset($post['from']['id']) || !isset($post['id']) || !isset($post['message'])){
				user_error('Facebook detail error or API changed', E_USER_WARNING);
				return;
			}

			/**
			 * If the post is from the user itself and not someone else, add the message and date to our feeds array.
			 */
			if(strpos($post['id'], $post['from']['id']) === 0){
				$posted = date_parse($post['created_time']);
				$feeds->push(new ArrayData(array(
					'Message' => DBField::create('Text', $post['message']),
					'Posted' => DBField::create(
						'SS_Datetime',
						$posted['year'] . '-' . $posted['month'] . '-' . $posted['day'] . ' ' . $posted['hour'] . ':' . $posted['minute'] . ':' . $posted['second']
					),
				)));
				$count++;
			}
		}
		return $feeds;
	}


}