<?php defined('SYSPATH') or die('No direct script access.');

/**
* Model for incidents in a case
 *
 * 
 * @author     Ahmed Salem <ahmed.elsayed.salem@gmail.com>
 */

class Case_incidents_Model extends ORM
{
	protected $belongs_to = array('case', 'incident');
	
	// Database table name
	protected $table_name = 'cases_incidents';
	
	
}
