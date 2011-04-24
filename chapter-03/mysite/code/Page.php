<?php


/**
 * Defining the base page.
 *
 * @package mysite
 */
class Page extends SiteTree {
}



/**
 * Controller for the base page.
 *
 * @package mysite
 */
class Page_Controller extends ContentController {


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


}