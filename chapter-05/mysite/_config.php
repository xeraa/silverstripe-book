<?php

/**
 * Define where custom code resides.
 */
global $project;
$project = 'mysite';
define('PROJECT_DIR', $project);


/**
 * Set environment: 'dev', 'test', or 'live'.
 */
Director::set_environment_type('dev');


/**
 * Database configuration.
 */
global $databaseConfig;
if(Director::isLive()){
	$databaseConfig = array(
		"type" => "MySQLDatabase",
		"server" => "localhost",
		"username" => "root",
		"password" => "secret",
		"database" => "silverstripe5",
	);
} else {
	$databaseConfig = array(
		"type" => "MySQLDatabase",
		"server" => "localhost",
		"username" => "root",
		"password" => "",
		"database" => "silverstripe5",
	);
}
MySQLDatabase::set_connection_charset('utf8');


/**
 * Enable hierarchical URLs.
 */
SiteTree::enable_nested_urls();


/**
 * Set the current language to English.
 */
i18n::set_default_lang('en_US');


/**
 * Enable error logging and mailing them out in non development mode.
 */
SS_Log::add_writer(new SS_LogFileWriter(Director::baseFolder() . '/logs/ss.log'), SS_Log::ERR);
SS_Log::add_writer(new SS_LogFileWriter(Director::baseFolder() . '/logs/ss.log'), SS_Log::WARN);
SS_Log::add_writer(new SS_LogFileWriter(Director::baseFolder() . '/logs/ss.log'), SS_Log::NOTICE);
ini_set("log_errors", "On");
ini_set("error_log", Director::baseFolder() . "/logs/php.log");
if(!Director::isDev()){
	SS_Log::add_writer(new SS_LogEmailWriter('admin@bar.com'), SS_Log::ERR);
	SS_Log::add_writer(new SS_LogEmailWriter('admin@bar.com'), SS_Log::WARN);
	SS_Log::add_writer(new SS_LogEmailWriter('admin@bar.com'), SS_Log::NOTICE);
}


/**
 * Setting up email related configurations.
 */
if(Director::isLive()){
	define('EMAIL', 'office@bar.com');
} else {
	define('EMAIL', 'admin@bar.com');
	Email::send_all_emails_to(EMAIL);
}
Email::setAdminEmail(EMAIL);


/**
 * Removing unused options in the CMS editor.
 */
HtmlEditorConfig::get('cms')->removeButtons('hr');
HtmlEditorConfig::get('cms')->removeButtons('ssflash');


/**
 * Make sure the page is only available via www (for SEO of the live site).
 */
Director::forceWWW();


/**
 * Disable JavaScript validators, using our own.
 */
Validator::set_javascript_validation_handler('none');


/**
 * Set the image quality higher than the default.
 */
GD::set_default_quality(85);


/**
 * If you're not in live mode, always flush the template cache plus display the templates and includes used.
 */
if(!Director::isLive()){
	SSViewer::flush_template_cache();
	SSViewer::set_source_file_comments(true);
}


/**
 * Add custom page fields.
 */
DataObject::add_extension('SiteConfig', 'CustomSiteConfig');