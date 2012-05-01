<?php defined('SYSPATH') or die('No direct script access.');
/**
 * FrontlineSMS Model
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license 
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author     Ushahidi Team <team@ushahidi.com> 
 * @package    Ushahidi - http://source.ushahididev.com
 * @module     FrontlineSMS Model  
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL) 
 */

class Case_Model extends ORM
{
	
	protected $belongs_to = array('incident');
	// Database table name
	protected $table_name = 'cases';
	// Define Case relations
        protected $has_many = array(
                                "incident"=>"cases_incidents",
                                "comment"=>"cases_comments"
                                );
}
