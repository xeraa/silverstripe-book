<?php


/**
 * Create a new membercard class.
 */
class Membercard extends DataObject {


	/**
	 * Add fields to the database.
	 */
	public static $db = array(
		'Sex' => "Enum('-, male, female', '-')",
		'FirstName' => 'Varchar(32)',
		'Surname' => 'Varchar(32)',
		'Birth' => 'Date',
		'Address' => 'Varchar(64)',
		'Zip' => 'Int',
		'City' => 'Varchar(32)',
		'Phone' => 'Int',
		'Email' => 'Varchar(64)',
		'CreateCard' => 'Boolean',
	);


	/**
	 * Add a (database) index for better performance.
	 */
	public static $indexes = array(
		'Email' => true,
	);


}