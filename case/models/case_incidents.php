<?php defined('SYSPATH') or die('No direct script access.');

/**
* Model for users in a group
 *
 * 
 * @author     John Etherton <john.etherton@gmail.com>
 */

class Case_incidents_Model extends ORM
{
	protected $belongs_to = array('case', 'incident');
	
	// Database table name
	protected $table_name = 'cases_incidents';
	
	
}
