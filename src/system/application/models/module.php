<?php
class Module extends Model {
/********************************************************************************
 *                                 CONSTRUCTOR
 ********************************************************************************/
  function Module() {
    parent::Model();
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
    // NEED TO ADD ADDITIONAL CHECKS FOR MALICIOUS CODE INSERTIONS
    $values = array();
    foreach($data AS $key=>$value) {
      array_push($values,"$key=".$this->db->escape($data[$key]));
    }
    $values = implode(", ",$values);
    $query = "UPDATE public.module SET $values WHERE id=$modid";
    $this->db->query($query);
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
    $query = "SELECT * FROM public.module WHERE id<> 1";
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
 
  /* PARAMS: $modid - module id
   * DESCRP: list all visualizations associated with this module.
   */
  function get_visualizations($modid) {  
    $query = "SELECT t1.id AS vis_id, t1.name, t1.template, t2.id AS modvizid, t2.viz_name, t2.stack AS viz_stacked FROM public.visualization AS t1, public.module_visualization AS t2 WHERE t1.id = t2.vizid AND t2.modid = $modid";
    $result = $this->db->query($query);
    return $result->result_array();    	
  }
  
  function add_mod_dataid($modid,$modvizid,$moddataid) {
    $query = "INSERT INTO public.mod_viz_data (modid,modvizid,moddataid) VALUES ($modid,$modvizid,$moddataid)";
    $this->db->query($query);
  }  

  /* PARAMS: $modid - id of the module to lookup
   * DESCRP: return array of users who have activated this module
   */
  function add_filter($module_id,$filter_id) {
    $query = "INSERT INTO public.module_filter (module_id,filter_id) VALUES ($module_id,$filter_id)";
    $this->db->query($query);
  }  

  /* PARAMS: $modid - id of the module to lookup
   * DESCRP: return array of filters for this module
   */
  function get_filters($module_id) {
    $query = "SELECT * FROM public.module_filter AS t1, public.filter AS t2 WHERE module_id=$module_id AND t1.filter_id=t2.id";
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

    // GET INDIVIDUAL MEMBER DATA
    $member_ids = $this->module->get_users($modid);
    $data['members'] = array();
    foreach($member_ids AS $mid) {
      array_push($data['members'],$this->user->get_profile($mid));
    }

    // GET TOTAL NUMBER OF MEMBERS
    $data['num_members'] = count($data['members']);       

    // GET TIME SERIES DATA FOR ALL MEMBERS
    $results = $this->get_dataset_results($modid);

    // GET TOTAL AMOUNT SPENT BY ALL MEMBERS
    $data['total_spend'] = 0;
    foreach($results AS $ds) {
      foreach($ds AS $d) {
	$data['total_spend'] += $d['value'];	   
      }
    }

    // GET TIME SERIES DATA FOR USER ONLY
    $results = $this->get_dataset_results($modid,$vis['modvizid'],7);

    // GET TOTAL AMOUNT SPENT BY USER ONLY
    $data['my_spend'] = 0;
    foreach($results AS $ds) {
      foreach($ds AS $d) {
	$data['my_spend'] += $d['value'];	   
      }
    }

    $data_sets = $this->module->get_data_sets($modid); 
    $data_sets = $this->format_viz_datasets($vis['modvizid'], $data_sets);
    $data['json'] = $this->viz->format_json($results, $data_sets);
    $data['vis'] = $vis;
    $this->load->view($vis['template'], $data);
  }

  /* PARAMS: $modid - id of the module
   *         $userid - id of the user to lookup
   *         $period - number used to determine the number of months to look back at
   *         $frequency - the rate at which transactions should be folded up, i.e. monthly, daily, yearly, etc...
   * DESCRP: constructs a query using the filters associated with a vis and the vis settings for period and frequency of aggregation.
   * RETURN: array(array()) of results data keyed by dataset title and user or module level aggregation
   */ 

  function get_dataset_results($module_id, $userid=0, $period='year', $frequency='month') {
    $filters = $this->get_filters($module_id);   
    $results = array();
    foreach($filters AS $ds) {                   
      // CONSTRUCT SELECT STATEMENT
      $query = "SELECT date_part('epoch', date_trunc('$frequency',created))*1000 AS label, abs(round(sum(amount)/100.0,2)) AS value FROM public.transaction";

      // CONTSRUCT MEMO STRING SQL FROM THE ASSOCIATED DATASETS
      $memos = $this->filter->get_memos($ds['filter_id']);
      for($i=0;$i<count($memos);$i++) {
	$memos[$i] = "memo ILIKE '%$memos[$i]%' OR merchant ILIKE '%$memos[$i]%'";
      }
      $memos = implode(' OR ',$memos);
      $query .= " WHERE $memos ";

      // APPEND PERIOD AND FREQUENCY PARAMS
      switch($period) {
      case 'as':
	$query .= "AND current_date > (date_trunc('day', created) - interval '1 year') ";
	break;
      default:
	break;
      }

      // LIMIT USERS TO LOOK AT
      if(!$userid) {
	$q = array();
	foreach($this->get_users($modid) AS $id) {
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
      $results[$ds['name']] = $result->result_array();
    }    
    return $results;
  }

  /* PARAMS: $data - serialized data from the query
   *         $data_sets - dataset meta data
   * DESCRP: returns json object of serialized data
   */
  function format_json($data, $data_sets) {  
    $tmp = array();
    foreach($data AS $key=>$value) {
      foreach($data_sets as $ds) {
	if($key== $ds['name']) {
	  $color= $ds['color'];
	  if($color== 'random') {
	    $colors= array('#0000FF', '#FF0000', '#F7FF00', '#00FF00', '#FF00DD', '#FF8F00');
	    shuffle($colors);
	    $color= $colors[0];
	  }
	}
      }
      $tmp2 = array();
      $j=0;
      foreach($value AS $v) {
	$tmp2[$j] = "[$v[label],$v[value]]";
	$j++;
      }
      array_push($tmp,"{label:'$key',color:'$color',data:[".implode(',',$tmp2)."]}");
    }
    return $json = "[".implode(',',$tmp)."]";    
  }
}