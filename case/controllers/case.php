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
		$this->template->content = new View('cases');
		
		$this->template->content->cases = ORM::factory('case')
					->orderby("id", "ASC")
					->find_all();
		
                
               // plugin::add_stylesheet('case/views/css/caseStyle');
		$this->template->header->header_block = $this->themes->header_block();
	}
        
         /*     * *********************************************************************************
     * OPen a case
     * @param bool|int $id The id no. of the group
     * @param bool|string $saved
     */

    function openCase($id = false, $saved = false) {



        $this->template->content = new View('open_case');
        $this->template->content->title = "Open Case";
        $this->themes->js = new View('open_case_js');



        $this->template->content->comments = array();
        $this->template->content->comment = '';



        // setup and initialize form field names
        $comments_array = array();
        $comment_id_array = array();

        $form = array
            (
            'email' => '',
            'comment' => '',
            'title' => '',
            'description' => '',
            'date' => '',
            'contact_person' => '',
            'contact_person_phone' => '',
        );



        //  copy the form as errors, so the errors will be stored with keys corresponding to the form field names
        $errors = $form;
        $rating = 0;
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
            $post->add_rules('comment', 'required', 'length[1,100]');
            $post->add_rules('email', 'required');

            // Test to see if things passed the rule checks
            if ($post->validate()) {


                // Save the Case
                $case_comment = new Case_comments_Model();
                $case_comment->comment = $post->comment;
                $case_comment->comment_ip = $_SERVER['REMOTE_ADDR'];
                $case_comment->comment_email = $post->email;
                $case_comment->cases_case_id = $id;
                $case_comment->comment_date = date("Y-m-d H:i:s", time());

                $case_comment->save();

                url::redirect('case_view/openCase/' . $id);

                $_id = $case_comment->id;
            }

            // No! We have validation errors, we need to show the form again, with the errors
            else {
                // repopulate the form fields
                $form = arr::overwrite($form, $post->as_array());
                // populate the error fields, if any
                $errors = arr::overwrite($errors, $post->errors('case'));
                $form_error = TRUE;
            }

            // Redirect
            //url::redirect('case_view/openCase/'.$id);
        } //end if($_POST)
        else {

            if ($id) {
                // Retrieve Current Case
                $case = ORM::factory('Case', $id);
                //Get incident IDs which linked to that case
                $comment_id_array = ORM::factory('case_comments')
                        ->select('*')
                        ->where(array('cases_case_id' => $id))
                        ->find_all();

//			echo "->>>>>>>>>".count($comment_id_array);
                //load form fields
                if ($case->loaded == true) {

                    // Combine Everything
                    $case_arr = array
                        (
                        'title' => $case->title,
                        'description' => $case->description,
                        'contact_person' => $case->contact_person,
                        'date' => $case->entry_date,
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
        $this->template->content->comments = $comment_id_array;
        $this->template->content->errors = $errors;
        $this->template->content->form_error = $form_error;
        $this->template->content->form_saved = $form_saved;
        $this->template->content->case_id = $case->id;
        $this->template->content->case = $case;
        // Incident rating
        $this->template->content->rating = $rating;

        $this->template->header->header_block = $this->themes->header_block();
    }

//end method

    /**
     * Report Rating.
     * @param boolean $id If id is supplied, a rating will be applied to selected report
     */
    public function rating($id = false) {

        $this->template = "";
        $this->auto_render = FALSE;

        if (!$id) {
            echo json_encode(array("status" => "error", "message" => "ERROR!"));
        } else {
            if (!empty($_POST['action']) AND !empty($_POST['type'])) {
                $action = $_POST['action'];
                $type = $_POST['type'];

                // Is this an ADD(+1) or SUBTRACT(-1)?
                if ($action == 'add') {
                    $action = 1;
                } elseif ($action == 'subtract') {
                    $action = -1;
                } else {
                    $action = 0;
                }

                if (!empty($action) AND ($type == 'original' OR $type == 'comment')) {
                    // Has this User or IP Address rated this post before?

                    $filter = "comment_ip = '" . $_SERVER['REMOTE_ADDR'] . "' ";
                    if ($type == 'original') {
                        $previous = ORM::factory('rating')
                                ->where('incident_id', $id)
                                ->where($filter)
                                ->find();
                    } elseif ($type == 'comment') {
                        $previous = ORM::factory('case_comments')
                                ->where('id', $id)
                                ->where($filter)
                                ->find();
                    }

                    // If previous exits... update previous vote
                    $rating = new Case_comments_Model($previous->id);

                    // Are we rating the original post or the comments?
                    if ($type == 'original') {
                        //$rating->incident_id = $id;
                    } elseif ($type == 'comment') {
                        $rating->id = $id;
                    }

                    // Is there a user?
                    // User can't rate their own stuff
                    if ($type == 'original') {
                        if ($rating->incident->user_id == $this->user->id) {
                            echo json_encode(array("status" => "error", "message" => "Can't rate your own Reports!"));
                            exit;
                        }
                    } elseif ($type == 'comment') {
                        // Check if comment rating user is who add this comment before.
                        if ($rating->comment_ip == $_SERVER['REMOTE_ADDR']) {
                            echo json_encode(array("status" => "error", "message" => "Can't rate your own Comments!"));
                            exit;
                        }
                    }


                    //$rating->rating = $rating->rating + $action;
                    $rating->comment_ip = $_SERVER['REMOTE_ADDR'];
                    $rating->comment_date = date("Y-m-d H:i:s", time());
                    $rating->save();

                    // Get total rating and send back to json
                    $total_rating = $this->_get_rating($id, $type);

                    echo json_encode(array("status" => "saved", "message" => "SAVED!", "rating" => $total_rating));
                } else {
                    echo json_encode(array("status" => "error", "message" => "Nothing To Do!"));
                }
            } else {
                echo json_encode(array("status" => "error", "message" => "Nothing To Do!"));
            }
        }
    }

    /**
     * Retrieves Total Rating For Specific Post
     * Also Updates The Incident & Comment Tables (Ratings Column)
     */
    private function _get_rating($id = FALSE, $type = NULL) {
        if (!empty($id) AND ($type == 'original' OR $type == 'comment')) {
            if ($type == 'original') {
                //  $which_count = 'incident_id';
            } elseif ($type == 'comment') {
                $which_count = 'id';
            } else {
                return 0;
            }

            $total_rating = 0;

            // Get All Ratings and Sum them up
            foreach (ORM::factory('case_comments')
                    ->where($which_count, $id)
                    ->find_all() as $rating) {
                $total_rating += $rating->rating;
            }

            // Update Counts
            if ($type == 'original') {
                // $incident = ORM::factory('incident', $id);
                // if ($incident->loaded == TRUE) {
                //  $incident->incident_rating = $total_rating;
                // $incident->save();
                // }
            } elseif ($type == 'comment') {
                $comment = ORM::factory('case_comments', $id);
                $comment->rating = $total_rating;
                $comment->save();
            }

            return $total_rating;
        } else {
            return 0;
        }
    }

}
