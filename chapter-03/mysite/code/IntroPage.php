<?php


/**
 * Intro page.
 *
 * @package mysite
 */
class IntroPage extends Page {
}



/**
 * Controller for the intro page.
 *
 * @package mysite
 */
class IntroPage_Controller extends Page_Controller {


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