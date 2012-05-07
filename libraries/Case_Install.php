<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Performs install/uninstall methods for the Case Plugin
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
               Kohana::log('debug', "welcome to Case Plugin, Activation , process [ Running ...]");
		
		$this->db =  new Database();
                $this->uninstall();
	}

	/**
	 * Creates the required columns for the cases Plugin
	 */
	public function run_install()
	{
		 Kohana::log('debug', "Case Plugin, Install DB , process [ Running ...]");
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
                                entry_date DATE NOT NULL,
				PRIMARY KEY (`id`)
			);
		");
		
		// ****************************************
		//create the table that tracks the incideints associated with a case
		$this->db->query('CREATE TABLE IF NOT EXISTS `'.Kohana::config('database.default.table_prefix').'cases_incidents` (
				  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
				  `cases_case_id` int(10) unsigned NOT NULL,
				  `incident_id` int(10) unsigned NOT NULL,
                                  PRIMARY KEY (`id`),
                                  KEY `cases_incidents_case_FK` (`cases_case_id`),
                                  CONSTRAINT `cases_incidents_case_FK` FOREIGN KEY (`cases_case_id`) REFERENCES `'.Kohana::config('database.default.table_prefix').'cases` (`id`)
				) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1');
				
		

                // ****************************************
		//create the table that tracks the incideints associated with a case
		$this->db->query('CREATE TABLE IF NOT EXISTS `'.Kohana::config('database.default.table_prefix').'cases_comments` (
				  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
				  `cases_case_id` int(10) unsigned NOT NULL,
                                  `comment_ip` varchar(100) DEFAULT NULL,
                                  `comment_email` varchar(120) DEFAULT NULL,                               
				  `comment` varchar(1020) NOT NULL,
                                  `comment_date` DATE NOT NULL,
                                  `rating` int(10) UNSIGNED NOT NULL DEFAULT 0 ,
				  PRIMARY KEY (`id`),
                                  KEY `case_comments_fk` (`cases_case_id`),
                                  CONSTRAINT `case_comments_fk` FOREIGN KEY (`cases_case_id`) REFERENCES `'.Kohana::config('database.default.table_prefix').'cases` (`id`)
				) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1');
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
             Kohana::log('debug', "Case Plugin, Uninstall DB , process [ Running ...]");
                $this->db->query("
			DROP TABLE IF EXISTS ".Kohana::config('database.default.table_prefix')."cases_comments;
			");
                
                $this->db->query("
			DROP TABLE IF EXISTS ".Kohana::config('database.default.table_prefix')."cases_incidents;
			");
                
		$this->db->query("
			DROP TABLE IF EXISTS ".Kohana::config('database.default.table_prefix')."cases;
			");
                
                
	}
}
