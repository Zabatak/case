<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * simplegroups helper class.
 */


class caseh_Core {


	// Table Prefix
	protected static $table_prefix;

	static function init()
	{
		// Set Table Prefix
		self::$table_prefix = Kohana::config('database.default.table_prefix');
	}
	
	  
	/**************************************************************************************************************
	* Given all the parameters returns a list of incidents that meet the search criteria
	**************************************************************************************************************/
	/*function to get the users that are already signed up for a group*/
	public function get_incidents_for_case( $id )
	{
		 
		$where_text = "incident.id = $id";
		//get all the users that have the 'simplegroups' role, but aren't part of other groups
		$cases = ORM::factory('incident')
			->select("incident.*")
			->where($where_text)
			->find();

		
		return $cases;
	}//end function
        
        /**************************************************************************************************************
	*Get All cases as array
	**************************************************************************************************************/
	public function get_cases(){
            
            $case_array = array();
            foreach (ORM::factory('case')->orderby('id')->find_all() as $case)
                            {
                                    // Create a list of all cases
                                    $this_case = $case->title;

                                    if (strlen($this_case) > 35)
                                    {
                                            $this_case = substr($this_case, 0, 35) . "...";
                                    }
                                    $case_array[$case->id] = $this_case;

                            }
            return $case_array;                
        }              
}//end class



	caseh_Core::init();

