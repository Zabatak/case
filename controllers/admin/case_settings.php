<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * FrontlineSMS Settings Controller
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license 
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author	   Ushahidi Team <team@ushahidi.com> 
 * @package    Ushahidi - http://source.ushahididev.com
 * @module	   Clickatell Settings Controller	
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL) 
 * 
 */
class Case_Settings_Controller extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->template->this_page = 'Case Settings';

        // If this is not a super-user account, redirect to dashboard
        if (!$this->auth->logged_in('admin') && !$this->auth->logged_in('superadmin')) {
            url::redirect('admin/dashboard');
        }
    }

    public function index() {
        $form_action = false;
        $this->template->this_page = 'addons';

        // Standard Settings View
        $this->template->content = new View('case/admin/case_settings');
        $this->template->content->title = "Case Settings";


        //get a list of cases expect first one
        $cases = ORM::factory('Case')
                ->orderby("id", "ASC")
                ->where(array('id !=' => 1))
                ->find_all();



        //pass parameters to screen
        $this->template->content->form_action = $form_action;
        $this->template->content->cases = $cases;
    }

    /*     * ********************************************************************************
     * Edit a case
     * @param bool|int $id The id no. 
     * @param bool|string $saved
     */

    function edit($id = false, $saved = false) {

        $incident_array = array();
        $incident_id_array = array();
        $this->template->content = new View('case/case_editcase');
        $this->template->content->title = "edit Case";
        $this->template->content->incidents = array();
        $this->template->content->incident = '';


        // setup and initialize form field names
        $form = array
            (
            'title' => '',
            'description' => '',
            'logo' => '',
            'contact_person' => '',
            'contact_person_phone' => '',
        );



        //  copy the form as errors, so the errors will be stored with keys corresponding to the form field names
        $errors = $form;
        $form_error = FALSE;
        if ($saved == 'saved') {
            $form_saved = TRUE;
        } else {
            $form_saved = FALSE;
        }

        // check, has the form been submitted, if so, setup validation
        if ($_POST) {
            // Instantiate Validation, use $post, so we don't overwrite $_POST fields with our own things
            $post = Validation::factory(array_merge($_POST, $_FILES));
            //  Add some filters
            $post->pre_filter('trim', TRUE);

            // Add some rules, the input field, followed by a list of checks, carried out in order
            // $post->add_rules('locale','required','alpha_dash','length[5]');
            $post->add_rules('title', 'required', 'length[1,100]');
            $post->add_rules('description', 'required');
            $post->add_rules('contact_person', 'required');

            // Test to see if things passed the rule checks
            if ($post->validate()) {

                echo $post->title . "Case desc" . $post->description;
                // Save the Case
                $case = new Case_Model($id);
                $case->title = $post->title;
                $case->description = $post->description;
                $case->contact_person = $post->contact_person;
                $case->contact_person_phone = $post->contact_person_phone;
                $case->entry_date = date("Y-m-d H:i:s", time());
                $case->save();



                $id = $case->id;


                // SAVE AND CLOSE?
                if ($post->save == 1) {       // Save but don't close
                    url::redirect('admin/case_settings/edit/' . $case->id . '/saved');
                } else {                        // Save and close
                    url::redirect('admin/case_settings/');
                }
            }
            // No! We have validation errors, we need to show the form again, with the errors
            else {
                // repopulate the form fields
                $form = arr::overwrite($form, $post->as_array());
                // populate the error fields, if any
                $errors = arr::overwrite($errors, $post->errors('case'));
                $form_error = TRUE;
            }
        } //end if($_POST)
        else {

            if ($id) {
                // Retrieve Current Case
                $case = ORM::factory('Case', $id);
                //Get incident IDs which linked to that case
                $incident_id_array = ORM::factory('case_incidents')
                        ->select('*')
                        ->where(array('cases_case_id' => $id))
                        ->find_all();


                $incident_array = array();

                //After getting Ids get incident data		
                foreach ($incident_id_array as $incident_id) {

                    $incident = caseh::get_incidents_for_case($incident_id->incident_id);
                    //Add incident object to array
                    array_push($incident_array, $incident);
                }

                //load form fields
                if ($case->loaded == true) {

                    // Combine Everything
                    $case_arr = array
                        (
                        'title' => $case->title,
                        'description' => $case->description,
                        'contact_person' => $case->contact_person,
                        'contact_person_phone' => $case->contact_person_phone,
                    );


                    // Merge To Form Array For Display
                    $form = arr::overwrite($form, $case_arr);
                } else {
                    // Redirect
                    //url::redirect('admin/simplegroup_settings/');
                }
            }
        }

        $this->template->content->id = $id;
        $this->template->content->form = $form;
        $this->template->content->incidents = $incident_array;
        $this->template->content->errors = $errors;
        $this->template->content->form_error = $form_error;
        $this->template->content->form_saved = $form_saved;



        // Javascript Header
        $this->template->editor_enabled = TRUE;
        $this->template->js = new View('case/case_editcase_js');
    }

//end method
}

