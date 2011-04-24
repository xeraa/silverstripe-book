<?php


/**
 * Defining the base page.
 *
 * @package mysite
 */
class Page extends SiteTree {


	/**
	 * WidgetArea to use on this page.
	 */
	public static $has_one = array(
		'SideBar' => 'WidgetArea',
	);


	/**
	 * Make the WidgetArea available in the CMS.
	 *
	 * @return FieldSet The added CMS fields.
	 */
	public function getCMSFields(){
		$fields = parent::getCMSFields();
		$fields->addFieldToTab('Root.Content.Widgets', new WidgetAreaEditor('SideBar'));
		return $fields;
	}


	/**
	 * Automatically prefix every page's title.
	 *
	 * @return string Put the site's name in front of every title.
	 */
	public function getMetaTitle(){
		return "Bar :: " . $this->Title;
	}


	/**
	 * Provide the short code for easily including Google Maps.
	 * Possible usages in a HTML field in the CMS:
	 *     [GMap location=http://maps.google.com/maps?f=q&source=s_q&hl=gb&geocode=&q=Fifth+Avenue,+5th+Avenue,+New+York,+NY,+United+States&sll=49.416073,11.117115&sspn=0.007887,0.014055&ie=UTF8&ll=40.769232,-73.953867&spn=0.049143,0.144196&z=14]
	 *     [GMap location=http://maps.google.com/maps?f=q&source=s_q&hl=gb&geocode=&q=Fifth+Avenue,+5th+Avenue,+New+York,+NY,+United+States&sll=49.416073,11.117115&sspn=0.007887,0.014055&ie=UTF8&ll=40.769232,-73.953867&spn=0.049143,0.144196&z=14 width=700 height=530]
	 *
	 * @param $attributes array The parameters that can be passed to the function.
	 * @param $content string (Optional) content for this short code.
	 * @param $parser string (Optional) parser to use for this short code.
	 * @return ArrayData Parameters to render the final output.
	 */
	public static function GMapHandler($attributes, $content = null, $parser = null){

		/**
		 * Check the mandatory argument location.
		 * For security reasons this must be a Google Maps page, otherwise you could include any page in the iframe which is not intended.
		 */
		if(!isset($attributes['location']) || !(strpos($attributes['location'], 'http://maps.google.com/maps') === 0)){
			return;
		}

		/**
		 * Check for the optional attributes of width and height.
		 */
		if(isset($attributes['width']) && ctype_digit($attributes['width'])){
			$width = $attributes['width'];
		} else {
			$width = 700;
		}
		if(isset($attributes['height']) && ctype_digit($attributes['height'])){
			$height = $attributes['height'];
		} else {
			$height = 530;
		}

		$customise = array();
		$customise['Location'] = $attributes['location'] . '&amp;output=embed';
		$customise['Width'] = $width;
		$customise['Height'] = $height;

		$template = new SSViewer('GMap');
		return $template->process(new ArrayData($customise));
	}


}



/**
 * Controller for the base page.
 *
 * @package mysite
 */
class Page_Controller extends ContentController {


	/**
	 * Functions exposed via their URL.
	 */
	public static $allowed_actions = array();


	/**
	 * Initializer, used on all pages.
	 */
	public function init(){
		parent::init();

		/**
		 * Reference and combine the CSS files.
		 */
		Requirements::themedCSS('print', 'print');
		$theme = SSViewer::current_theme();
		Requirements::combine_files('combined.css', array(
			THEMES_DIR . '/' . $theme . '/css/layout.css',
			THEMES_DIR . '/' . $theme . '/css/typography.css',
			THEMES_DIR . '/' . $theme . '/css/form.css',
		));

		/**
		 * Add IE specific styling.
		 */
		Requirements::insertHeadTags('
			<!--[if lt IE 9]>
				<style type="text/css">
					.transparent {
						background: transparent;
						-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#44FFFFFF,endColorstr=#B2FFFFFF)"; /* IE8 */
						filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#44FFFFFF,endColorstr=#B2FFFFFF); /* IE6 & 7 */
						zoom: 1;}
					}
				</style>
			<![endif]-->
		', 'IE-styling');

		/**
		 * Kill Prototype and use jQuery instead.
		 */
		Requirements::block(THIRDPARTY_DIR . '/prototype/prototype.js');
		Requirements::block(THIRDPARTY_DIR . '/behaviour/behaviour.js');
		Requirements::block(SAPPHIRE_DIR . '/javascript/prototype_improvements.js');
		Requirements::block(SAPPHIRE_DIR . '/javascript/ConfirmedPasswordField.js');
		Requirements::block(SAPPHIRE_DIR . '/javascript/ImageFormAction.js');
		Requirements::block(THIRDPARTY_DIR . '/jquery/jquery.js');
		Requirements::javascript(THIRDPARTY_DIR . '/jquery/jquery-packed.js');

		/**
		 * Use spam protected emails which look like regular ones.
		 */
		Requirements::customScript("
			$(document).ready(function(){
				$('span.mail').each(function(){
					$(this).replaceWith($(this).text().replace(/ at /, '@').replace(/ dot /g, '.'));
				});
			});
		", 'mail-protect');

		/**
		 * Include Google Analytics only in live mode.
		 */
		if(Director::isLive()){
			Requirements::customScript("
				var _gaq = _gaq || [];
				_gaq.push(['_setAccount', 'UA-XXXXXXXX-X']);
				_gaq.push(['_trackPageview']);
				(function(){
					var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
					ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
					var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
				})();
			", 'google-analytics');
		}

	}


	/**
	 * Get the current URL, including parameters for caching pages.
	 *
	 * @return String 
	 */
	protected function CacheSegment(){
		return $_SERVER["REQUEST_URI"];
	}


	/**
	 * Provide the hits of the result page.
	 *
	 * @param $data array The user input.
	 * @param $form SearchForm The form itself for referencing it.
	 * @param $request Request generated for this action.
	 * @return ViewableData For empty results redirect back, otherwise return the results in an array and use the SearchResults page.
	 */
	public function results($data, $form, $request){
		if(!empty($data['Search'])){
			$templateData = array(
				'Results' => $form->getResults(3, $data),
				'SearchQueryTitle' => $form->getSearchQuery($data),
			);
			return $this->customise($templateData)->renderWith(array(
				'Page_results',
				'Page',
			));
		} else {
			Director::redirectBack();
			return;
		}
	}


}