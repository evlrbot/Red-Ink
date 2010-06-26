<?php
/*
Red Ink - Consumer Analytics for People and Communities
Copyright (C) 2010  Ryan O'Toole

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU Affero General Public License as
published by the Free Software Foundation, either version 3 of the
License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

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
    $module['public'] = isset($data['public']) ? "true" : "false";
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

 /* Load invitation popup
    Params: $site_url - invitation view page
 */
  function invite_popup($site_url) {



 }

  
/********************************************************************************
 *                               ACCESSOR METHODS
 ********************************************************************************/
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

  /* PARAMS: $module_id - id of the module to lookup
   *         $user_id - id of the user to lookup 
   * DESCRP: return true if the user is a member of the module
   */
  function has_user($module_id, $user_id) {
    $query = "SELECT count(userid) AS is_member FROM public.user_module WHERE modid = $module_id AND userid = $user_id";
    $result = $this->db->query($query);
    $result = $result->row_array();
    return $result['is_member']
;
  }

  /* PARAMS: $modid - module id
   * DESCRP: load the template for the visualization.
   */  
  function load($modid, $embed=0) {
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
    $visits = 0;
    foreach($time_series AS $ds) {
      foreach($ds['data'] AS $d) {
	$data['total_spend'] += $d['value'];
	if($d['value']) {
	  $visits++;
	}
      }
    }

    // GET THE AVERAGE SPEND PER INTERVAL
    $interval = 0;
    $period = $data['module']['period'];
    switch($data['module']['frequency']) {
    case 'day':
      $interval = $period * 30;
      break;
    case 'week':
      $interval = ($period * 30) / 7;
      break;
    case 'month':
      $interval = $period;
      break;
    default:
    }
    $data['avg_spend_per_interval'] = round($data['total_spend'] / $interval, 2);
    if($visits) { 
      $data['avg_spend_per_visit'] = round($data['total_spend'] / $visits, 2); 
    }
    else {
      $data['avg_spend_per_visit'] = 0;
    }
    $userid = isset($_SESSION['userid']) ? $_SESSION['userid'] : 0;
    if($this->has_user($data['module']['id'],$userid)) {
      // GET TIME SERIES DATA FOR USER ONLY
      $time_series_user = $this->get_dataset_results($modid,$_SESSION['userid'],$data['module']['period'],$data['module']['frequency']);
      // GET TOTAL AMOUNT SPENT BY USER ONLY
      $data['my_spend'] = 0;
      foreach($time_series_user AS $ds) {
	foreach($ds['data'] AS $d) {
	  $data['my_spend'] += $d['value'];	   
	}
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
      $query .= "WHERE (created > current_date - interval '$period months')";

      // CONTSRUCT MEMO STRING SQL FROM THE ASSOCIATED DATASETS
      $memos = $this->filter->get_memos($ds['filter_id']);
      $tmp = array();
      foreach($memos AS $m) {
	$m['memo'] = $this->db->escape("%$m[memo]%");
	array_push($tmp,"memo ILIKE $m[memo] OR merchant ILIKE $m[memo]");
      }
      $memos = implode(' OR ',$tmp);
      $query .= !empty($memos) ? " AND ($memos) " : '';

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

      // PREPARE RETURN RESULTS
      $results[$ds['name']]['data'] = $result->result_array();
      $results[$ds['name']]['active'] = $ds['active'];
      $results[$ds['name']]['color'] = $ds['color'];
    }    

    // STUFF RESULTS WITH EMPTY VALUES FOR NULL SETS
    $offsets = array();
    $interval = 0;
    switch($frequency) {
    case 'day':
      $interval = $period * 30;
      break;
    case 'week':
      $interval = ($period * 30) / 7;
      break;
    case 'month':
      $interval = $period;
      break;
    default:
    }

    for($i=$interval;$i>=0;$i--) {
      $query = "SELECT date_part('epoch',date_trunc('$frequency',current_date - interval '$i $frequency'))*1000 AS offset";
      $r = $this->db->query($query);
      $r = $r->row_array();
      array_push($offsets,$r['offset']);
    }
    foreach(array_keys($results) AS $filter) { // filters
      $tmp = array();
      foreach($results[$filter]['data'] AS $d) { // time series data points
	$tmp[$d['label']] = $d['value'];
      }
      foreach($offsets AS $offset) {
	if(!isset($tmp[$offset])) {
	  $tmp[$offset] = 0;
	}
      }
      ksort($tmp);
      $tmp2 = array();
      foreach($tmp AS $label=>$value) {
	array_push($tmp2,array('label'=>$label,'value'=>$value));	
      }
      $results[$filter]['data'] = $tmp2;
    }
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
