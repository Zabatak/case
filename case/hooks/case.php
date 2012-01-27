<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Case Hook - Load All Events
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license 
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author	   Ushahidi Team <team@ushahidi.com> 
 * @package	   Ushahidi - http://source.ushahididev.com
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license	   http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL) 
 */

class caseHook {
	
	/**
	 * Registers the main event add method
	 */
	public function __construct()
	{
		 
		$this->case_array = array();
		$this->case_id = '';
		
		 
		
		// Hook into routing
		Event::add('system.pre_controller', array($this, 'add'));
	}
	
	/**
	 * Adds all the events to the main Ushahidi application
	 */
	public function add()
	{
		// Only add the events if we are on that controller
		if (Router::$controller == 'reports')
		{
			switch (Router::$method)
			{
				// Hook into the Report Add/Edit Form in Admin
				case 'edit':
					// Hook into the form itself
					Event::add('ushahidi_action.report_form_admin', array($this, '_report_form'));
					// Hook into the report_submit_admin (post_POST) event right before saving
					// Event::add('ushahidi_action.report_submit_admin', array($this, '_report_validate'));
					// Hook into the report_edit (post_SAVE) event
					Event::add('ushahidi_action.report_edit', array($this, '_report_form_submit'));
					break;
				// Hook into the Report view (front end)
				case 'view':
					plugin::add_stylesheet('case/views/css/actionable');
					Event::add('ushahidi_action.report_meta', array($this, '_report_view'));
					break;
				
			}
		}
		 
	}
	
	/**
	 * Add Actionable Form input to the Report Submit Form
	 */
	public function _report_form()
	{
		// Load the View
		$form = View::factory('case_form');
		// Get the ID of the Incident (Report)
		$id = Event::$data;
		
		if ($id)
		{
			// Do We have an Existing Actionable Item for this Report?
			$case_item = ORM::factory('case_incidents')
				->where('incident_id', $id)
				->find();
			
			 
			
			// Get cases
			$this->case_array = caseh::get_cases();
			
			 	
		}
		
		//send case_id to form
		$form->case_id = $this->case_id;
		//send case array to form
		$form->case_array = $this->case_array;
		
		$form->render(TRUE);
	}
	
	/**
	 * Handle Form Submission and Save Data
	 */
	public function _report_form_submit()
	{
		$incident = Event::$data;
		//add hok with report submit and skip if case selected = [---------]
		if ($_POST && $_POST['case_id'] !=1)
		{
			$case_item = ORM::factory('case_incidents')
				->where('incident_id', $incident->id)
				->find();
				
			$case_item->incident_id = $incident->id;
			
			$case_item->cases_case_id = isset($_POST['case_id']) ? 
				$_POST['case_id'] : "";
			
			$case_item->save();
			
		}
	}//end of method
        
        /**
	 * Render the Action Taken Information to the Report
	 * on the front end
	 */
	public function _report_view()
	{
		$incident_id = Event::$data;
		if ($incident_id)
		{
			$caseview = ORM::factory('case_incidents')
				->where('incident_id', $incident_id)
				->find();
			
			if ($caseview->loaded)
			{	
					//get case id
					$case_id = $caseview->cases_case_id;
					
					$case = ORM::factory('case')
								->where('id',$case_id)
								->find();
					 
					$report = View::factory('case_report');
					
					$report->case_name= $case;
					
					$report->render(TRUE);
				
			}
		}
	}
	
	

}

new caseHook;