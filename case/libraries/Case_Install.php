<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Performs install/uninstall methods for the FrontlineSMS Plugin
 *
 * @package    Ushahidi
 * @author     Ushahidi Team
 * @copyright  (c) 2008 Ushahidi Team
 * @license    http://www.ushahidi.com/license.html
 */
class Case_Install {
	
	/**
	 * Constructor to load the shared database library
	 */
	public function __construct()
	{
		$this->db =  new Database();
	}

	/**
	 * Creates the required columns for the cases Plugin
	 */
	public function run_install()
	{
		
		// ****************************************
		// DATABASE STUFF
		$this->db->query("
			CREATE TABLE IF NOT EXISTS `".Kohana::config('database.default.table_prefix')."cases`
			(
				id int(11) unsigned NOT NULL AUTO_INCREMENT,
				title varchar(50) DEFAULT NULL,
				contact_person varchar(50) DEFAULT NULL,
				contact_person_phone varchar(50) DEFAULT NULL,
				description longtext,
				logo varchar(200) default NULL,
				PRIMARY KEY (`id`)
			);
		");
		
		// ****************************************
		//create the table that tracks the incideints associated with a case
		$this->db->query('CREATE TABLE IF NOT EXISTS `'.Kohana::config('database.default.table_prefix').'cases_incidents` (
				  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
				  `cases_case_id` int(10) unsigned NOT NULL,
				  `incident_id` int(10) unsigned NOT NULL,
				  PRIMARY KEY (`id`)
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1');
				
		//Create defualt entry in case table
		//insert into cases (`id`,`title`,`contact_person`,`contact_person_phone`,`description`)values(0,"","","","")
		$this->db->query("INSERT INTO `".Kohana::config('database.default.table_prefix')."cases` (`id` ,`title` ,`contact_person` ,`contact_person_phone` ,
				`description` ,`logo`)
				VALUES (NULL ,  '-------------',  '',  '',  '',  '');");
		 
		
	}

	/**
	 * Drops the cases Tables
	 */
	public function uninstall()
	{
		$this->db->query("
			DROP TABLE ".Kohana::config('database.default.table_prefix')."cases;
			");
	}
}