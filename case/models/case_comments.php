<?php defined('SYSPATH') or die('No direct script access.');

/**
* Model for comments in a case
 *
 * 
 * @author     Ahmed Salem <Ahmed.ElSayed.Salem@gmail.com>
 */

class Case_comments_Model extends ORM
{
	
	protected $belongs_to = array('cases');
	
	// Database table name
	protected $table_name = 'cases_comments';
	
	
}
