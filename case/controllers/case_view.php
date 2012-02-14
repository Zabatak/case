<?php defined('SYSPATH') or die('No direct script access.');
/**
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

class Case_View_Controller extends Main_Controller {
	

public function __construct()
	{
		parent::__construct();

		$this->themes->validator_enabled = TRUE;
	}
	
	 
	
	public function index()
	{
		// Cacheable Controller
		$this->is_cachable = TRUE;
		
//		$this->template->header->this_page = 'reports';
//		$this->template->content = new View('show_cases');
//		
//		$this->template->content->cases = ORM::factory('case')
//					->orderby("id", "ASC")
//					->find_all();
//		
// 
//
//		$this->template->header->header_block = $this->themes->header_block();
	}
        
     	 /***********************************************************************************
    * OPen a case
    * @param bool|int $id The id no. of the group
    * @param bool|string $saved
    */
    function openCase( $id = false, $saved = false )
    {
		 
        $comments_array = array();
        $comment_id_array = array();        
        
        $this->template->content = new View('open_case');
        $this->template->content->title = "Open Case";
        $this->template->content->comments = array();
        $this->template->content->comment = '';

		 
        // setup and initialize form field names
        $form = array
        (
            'email'      => '',
            'comment'      => '',
             'title'      => '',
            'description'      => '',
          
            'contact_person' =>'',
            'contact_person_phone' =>'',
			
        );
	
	 

        //  copy the form as errors, so the errors will be stored with keys corresponding to the form field names
        $errors = $form;
        $form_error = FALSE;
        if ($saved == 'saved')
        {
            $form_saved = TRUE;
        }
        else
        {
            $form_saved = FALSE;
        }

        // check, has the form been submitted, if so, setup validation
        if ($_POST)
        {
			// Instantiate Validation, use $post, so we don't overwrite $_POST fields with our own things
			$post = Validation::factory(array_merge($_POST,$_FILES));
			//  Add some filters
			$post->pre_filter('trim', TRUE);
	
			// Add some rules, the input field, followed by a list of checks, carried out in order
			// $post->add_rules('locale','required','alpha_dash','length[5]');
			$post->add_rules('comment','required', 'length[1,100]');
			$post->add_rules('email','required');
			
			// Test to see if things passed the rule checks
			if ($post->validate())
			{
				
				
				// Save the Case
				$case_comment = new Case_comments_Model($id);
				$case_comment->comment = $post->comment;
				$case_comment->comment_ip = $post->comment->ip_address();
				$case_comment->comment_email = $post->email;
				$case_comment->cases_case_id = $id;
				$case->save();
				
								
				 
				$id = $case_comment->id;
		
	
			}
			// No! We have validation errors, we need to show the form again, with the errors
			else
			{
				// repopulate the form fields
				$form = arr::overwrite($form, $post->as_array());
				// populate the error fields, if any
				$errors = arr::overwrite($errors, $post->errors('case'));
				$form_error = TRUE;
			}
        } //end if($_POST)
        else
        {

		if ( $id )
		{
			// Retrieve Current Case
			$case = ORM::factory('Case', $id);			
			//Get incident IDs which linked to that case
			$comment_id_array = ORM::factory('case_comments')
							->select('*')
							->where(array('cases_case_id' => $id))
							->find_all();
			
			
			$comments_array = array();
			 
			//After getting Ids get incident data		
			foreach($comments_array as $comment_id){
			
				$comment = caseh::get_comments_for_case($comment_id->id);
				//Add incident object to array
				array_push($comments_array,$comment);
				
			}
			
			//load form fields
			if ($case->loaded == true)
			{
			
				// Combine Everything
				$case_arr = array
				(
					'title' => $case->title,
					'description' => $case->description,
					'contact_person'=>$case->contact_person,
					'contact_person_phone' =>$case->contact_person_phone,
					
				
				);
				
				
				// Merge To Form Array For Display
				$form = arr::overwrite($form, $case_arr);
				
			}
			else
			{
			    // Redirect
			    //url::redirect('admin/simplegroup_settings/');

			}
		}
		
			
        }

        $this->template->content->id = $id;
        $this->template->content->form = $form;
	$this->template->content->comments = $comments_array;
        $this->template->content->errors = $errors;
        $this->template->content->form_error = $form_error;
        $this->template->content->form_saved = $form_saved;
	


        // Javascript Header
        $this->template->editor_enabled = TRUE;
        $this->template->js = new View('case/case_editcase_js');
        $this->template->header->header_block = $this->themes->header_block();
    }//end method
	   
}