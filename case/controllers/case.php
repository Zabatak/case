<?php defined('SYSPATH') or die('No direct script access.');
/**
 * 
 * Viddler Controller
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license 
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author	   Ushahidi Team <team@ushahidi.com> 
 * @package	   Ushahidi - http://source.ushahididev.com
 * @module	   Clickatell Controller	
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license	   http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL) 
*/

class Case_Controller extends Main_Controller {
	

	public function __construct()
	{
		parent::__construct();

		$this->themes->validator_enabled = TRUE;
	}
	
	 
	
	public function index()
	{
		// Cacheable Controller
		$this->is_cachable = TRUE;
		
		$this->template->header->this_page = 'reports';
		$this->template->content = new View('show_cases');
		
		$this->template->content->cases = ORM::factory('case')
					->orderby("id", "ASC")
					->find_all();
		
 

		$this->template->header->header_block = $this->themes->header_block();
	}
}
