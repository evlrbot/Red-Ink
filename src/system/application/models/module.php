<?php
class Module extends Model {
/********************************************************************************
 *                                 CONSTRUCTOR
 ********************************************************************************/
  function Module() {
    parent::Model();
    $this->load->model('filter');
  }

/********************************************************************************
 *                                WRITE METHODS
 ********************************************************************************/
  /* PARAMS: $data
   * DESCRP: create a new module with the provided meta data
   */
  function create_module($userid,$data) {
    // ESCAPE INSERTION STRINGS, 
    // NEED TO ADD ADDITIONAL CHECKS FOR MALICIOUS CODE INSERTIONS
    for($i=0;$i<count($data);$i++) {
      $data[$i] = $this->db->escape($data[$i]);
    }
    // ADD MODULE
    $query = "INSERT INTO public.module (name,description) VALUES (".implode(",",$data).")";
    $this->db->query($query);
    $modid = $this->db->insert_id();
    // ADD OWNER
    $query = "INSERT INTO public.owner (userid,modid) VALUES ($userid,$modid)";
    $this->db->query($query);
  }

  /* PARAMS: $modid - module to update
   *         $data - array of data to update
   * DESCRP: update the module with the data
   */
  function update_module($modid,$data) {
    // UPDATE MODULE DATA
    $module['name'] = $data['name'];
    $module['description'] = $data['description'];
    $module['period'] = $data['period'];
    $module['frequency'] = $data['frequency'];
    $module['stacked'] = isset($data['stacked']) ? "true" : "false";
    $values = array();
    foreach($module AS $key=>$value) {
      array_push($values,"$key=".$this->db->escape($module[$key]));
    }
    $values = implode(", ",$values);
    $query = "UPDATE public.module SET $values WHERE id=$modid";
    $this->db->query($query);

    // UPDATE FILTER DATA
    foreach($this->module->get_filters($modid) as $d) {      
      $active = isset($_POST[$d['filter_id']."_active"]) ? 'true' : 'false'; 
      $color = $_POST[$d['filter_id']."_color"];
      $query = "UPDATE public.module_filter SET active='$active', color='$color' WHERE filter_id=$d[filter_id]";
      $this->db->query($query);
    }    
    redirect(site_url("campaign/edit/$modid"));
  }

  /* PARAMS: $modid - module to delete
   * DESCRP: remove referrences to this module
   *         in the appropriate tabels
   */
  function delete_module($modid) {
    $query = "DELETE FROM public.module WHERE id=$modid";
    $this->db->query($query);
    $query = "DELETE FROM public.owner WHERE modid=$modid";
    $this->db->query($query);
  }

  /* PARAMS: $modid - module to deactivate
   * DESCRP: Flag module as deactivated.
   */
  function deactivate_module($modid) {
    $query = "UPDATE public.module SET active=0 WHERE id=$modid";
    $this->db->query($query);
  }

  /* PARAMS: $modid - module to activate
   * DESCRP: Flag module as active.
   */
  function activate_module($modid) {
    $query = "UPDATE public.module SET active=1 WHERE id=$modid";
    $this->db->query($query);
  }

  /* PARAMS: $userid - user to lookup
   *         $modid - module to lookup
   * DESCRP: add module to user account
   */
  function add_user($userid,$modid) {
    $query = "INSERT INTO public.user_module (userid,modid) VALUES ($userid,$modid)";
    $this->db->query($query);
  }

  /* PARAMS: $userid - user to lookup
   *         $modid - module to lookup
   * DESCRP: rm user user from module
   */
  function remove_user($userid,$modid) {
    $query = "DELETE FROM public.user_module WHERE userid='$userid' AND modid='$modid'";
    $this->db->query($query);
  }

  /* PARAMS: $dataid - dataset id
   *         $name - dataset name
   *         $query - dataset query
   * DESCRP: update the dataset with new data
   */
  function update_data_set($dataid,$name,$query) {
    $name = $this->db->escape($name);
    $query = $this->db->escape($query);
    $q = "UPDATE public.data SET name=$name, query=$query WHERE id=$dataid";
    $this->db->query($q);
  }

  
/********************************************************************************
 *                               ACCESSOR METHODS
 ********************************************************************************/
  /* PARAMS: $modid
   * DESCRP: return associative array of data ids, labels and query strings
   */
  function get_data_sets($modid) {
    $query = "SELECT t2.name, t2.id AS dataid, t2.query, '' AS checked, '' AS color FROM public.module_data AS t1, public.data AS t2 WHERE modid=$modid AND t1.dataid = t2.id ORDER BY t1.order ASC";
    $result = $this->db->query($query);    
    return $result->result_array();
  }

  /* PARAMS: $viewid
   * DESCRP: For a given view returns the view's associate template file path
   */
  function get_template($modviewid) {
    $query = "SELECT v.template, v.multidata, v.stack FROM visualization AS v, module_visualization AS mv WHERE mv.id=$modviewid AND mv.vizid= v.id LIMIT 1";
    $result = $this->db->query($query);
    $tmp = $result->row_array();
    return $tmp;
  }

  /* PARAMS: void
   * DESCRP: return list of all modules except sample module id 1
   */
  function get_modules() {
    $query = "SELECT * FROM public.module WHERE active=true ORDER BY name ASC";
    $result = $this->db->query($query);
    return $result->result_array();
  }

  /* PARAMS: $modid
   * DESCRP: return info on the given module
   */
  function get_module($modid) {
    $query = "SELECT * FROM public.module WHERE id=$modid LIMIT 1";
    $result = $this->db->query($query);
    return $result->row_array();
  }
 
  /* PARAMS: $module_id - id of the module
   *         $filter_id - id of the filter
   * DESCRP: make the filter available to the module
   */
  function add_filter($module_id,$filter_id) {
    $query = "INSERT INTO public.module_filter (module_id,filter_id) VALUES ($module_id,$filter_id)";
    $this->db->query($query);
  }  

  /* PARAMS: $module_id - id of the module
   *         $filter_id - id of the filter
   * DESCRP: remove the filter from the module
   */
  function remove_filter($module_id,$filter_id) {
    $query = "DELETE FROM public.module_filter WHERE module_id=$module_id AND filter_id=$filter_id";
    $this->db->query($query);
  }  

  /* PARAMS: $modid - id of the module to lookup
   * DESCRP: return array of filters for this module
   */
  function get_filters($module_id) {
    $query = "SELECT *, t1.active AS active FROM public.module_filter AS t1, public.filter AS t2 WHERE module_id=$module_id AND t1.filter_id=t2.id";
    $result = $this->db->query($query);
    return $result->result_array();
  }  

  /* PARAMS: $modid - id of the module to lookup
   * DESCRP: return array of users who have activated this module
   */
  function get_users($modid) {
    $query = "SELECT userid FROM public.user_module WHERE modid = $modid";
    $result = $this->db->query($query);
    $userids = array();
    foreach($result->result_array() AS $u) {
      array_push($userids,$u['userid']);
    }
    return $userids;
  }

  /* PARAMS: $modid - module id
   * DESCRP: load the template for the visualization.
   */  
  function load($modid) {
    // get average spend
    // get individual total spend
    // get individual average spend
    // get total visits
    // get total individual visits
    // get average spend/visit

    // GET MODULE DATA
    $data['module'] = $this->get_module($modid);

    // GET INDIVIDUAL MEMBER DATA
    $member_ids = $this->module->get_users($modid);
    $data['members'] = array();
    foreach($member_ids AS $mid) {
      array_push($data['members'],$this->user->get_profile($mid));
    }

    // GET TOTAL NUMBER OF MEMBERS
    $data['num_members'] = count($data['members']);       

    // GET TIME SERIES DATA FOR ALL MEMBERS
    $time_series = $this->get_dataset_results($modid,0,$data['module']['period'],$data['module']['frequency']);

    // GET TOTAL AMOUNT SPENT BY ALL MEMBERS
    $data['total_spend'] = 0;
    foreach($time_series AS $ds) {
      foreach($ds['data'] AS $d) {
	$data['total_spend'] += $d['value'];	   
      }
    }

    // GET TIME SERIES DATA FOR USER ONLY
    $time_series_user = $this->get_dataset_results($modid,$_SESSION['userid'],$data['module']['period'],$data['module']['frequency']);

    // GET TOTAL AMOUNT SPENT BY USER ONLY
    $data['my_spend'] = 0;
    foreach($time_series_user AS $ds) {
      foreach($ds['data'] AS $d) {
	$data['my_spend'] += $d['value'];	   
      }
    }

    $data['filters'] = $this->get_filters($modid); 
    $data['json'] = $this->format_json($time_series);
    $this->load->view("modules/area_chart", $data);
  }
  
  /* PARAMS: $modid - id of the module
   *         $userid - id of the user to lookup
   *         $period - number used to determine the number of months to look back at
   *         $frequency - the rate at which transactions should be folded up, i.e. monthly, daily, yearly, etc...
   * DESCRP: constructs a query using the filters associated with a vis and the vis settings for period and frequency of aggregation.
   * RETURN: array(array()) of results data keyed by dataset title and user or module level aggregation
   */ 
  function get_dataset_results($module_id, $userid=0, $period='12', $frequency='month') {
    // DISCARD INACTIVE FILTERS
    $filters = array();
    foreach($this->get_filters($module_id) AS $filter) {
      if($filter['active'] == 't') {
	array_push($filters,$filter);
      }      
    }

    $results = array(); // ONE INDEX OF TIME SERIES DATA PER FILTER
    foreach($filters AS $ds) {                   
      // CONSTRUCT SELECT STATEMENT
      $query = "SELECT date_part('epoch', date_trunc('$frequency',created))*1000 AS label, abs(round(sum(amount)/100.0,2)) AS value FROM public.transaction ";

      // APPEND PERIOD AND FREQUENCY PARAMS
      $query .= "WHERE created > current_date - interval '$period months'";

      // CONTSRUCT MEMO STRING SQL FROM THE ASSOCIATED DATASETS
      $memos = $this->filter->get_memos($ds['filter_id']);
      $tmp = array();
      foreach($memos AS $m) {
	$m['memo'] = $this->db->escape("%$m[memo]%");
	array_push($tmp,"memo ILIKE $m[memo] OR merchant ILIKE $m[memo]");
      }
      $memos = implode(' OR ',$tmp);
      $query .= !empty($memos) ? " AND $memos " : '';

      // LIMIT USERS TO LOOK AT
      if(!$userid) {
	$q = array();
	foreach($this->get_users($module_id) AS $id) {
	  array_push($q,"userid=$id");
	}
	$users = implode(' OR ',$q);
      }
      else {
	$users = "userid=$userid";
      }
      $query .= $users ? " AND ($users) " : "";

      // AGGREGATE BY...
      $query .= "GROUP BY date_part('epoch', date_trunc('$frequency',created))*1000 ORDER BY label ASC";
      //echo "<p>$query</p>";
      $result = $this->db->query($query);
      $results[$ds['name']]['data'] = $result->result_array();
      $results[$ds['name']]['active'] = $ds['active'];
      $results[$ds['name']]['color'] = $ds['color'];
    }    
    /*    
    for($i=$period;$i>=0;$i--) {
      $query = "SELECT date_part('epoch',date_trunc('$frequency',current_date - interval '$i months')) AS offset";
      $result = $this->db->query($query);
      $offset = $result->row_array();
      $offset = $offset['offset'];
      foreach(array_keys($results) AS $key) {
	//	foreach($results[$key] AS 
      }
    }
    */
    return $results;
  }

  /* PARAMS: $data - serialized data from the query
   *         $data_sets - dataset meta data
   * DESCRP: returns json object of serialized data
   */
  function format_json($data) {  
    $tmp = array();
    foreach($data AS $key=>$value) {
      $color = $value['color'];
      $key = addslashes($key);
      $tmp2 = array();
      $j=0;
      foreach($value['data'] AS $d) {
	$tmp2[$j] = "[$d[label],$d[value]]";
	$j++;
      }
      array_push($tmp,"{label:'$key',color:'$color', data:[".implode(',',$tmp2)."]}");
    }    
    return $json = "[".implode(',',$tmp)."]";
  }
}