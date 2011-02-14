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

class Flodel extends Model {
/********************************************************************************
 *                                 CONSTRUCTOR
 ********************************************************************************/
  function Flodel() {
    parent::Model();
    $this->load->model('option');
  }

  /* PARAMS: $modid - module id
   * DESCRP: load the module for display
   */  
  function load($data) {
    
    // GET MODULE OPTIONS
    $data['options'] = array();
    $options = $this->module->get_options($data['module']['id']);
    //print_r($options);
    foreach($options AS $opt) {
      $data['options'][$opt['name']] = $opt['value'];
    }
    //print_r($data);
    // GET MODULE USERS
    $member_ids = $this->module->get_users($data['module']['id']);
    $data['members'] = array();
    foreach($member_ids AS $mid) {
      array_push($data['members'],$this->user->get_profile($mid));
    }

    // GET TOTAL NUMBER OF MEMBERS
    $data['num_members'] = count($data['members']);       

    // GET TIME SERIES DATA FOR ALL MEMBERS    
    $time_series = $this->get_data($data['module']['id'],0,$data['options']['Period'],$data['options']['Frequency']);
    
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
    $period = $data['options']['Period'];
    switch($data['options']['Frequency']) {
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
    if($this->module->has_user($data['module']['id'],$userid)) {
      // GET TIME SERIES DATA FOR USER ONLY
      $time_series_user = $this->get_data($data['module']['id'],$_SESSION['userid'],$data['options']['Period'],$data['options']['Frequency']);
      // GET TOTAL AMOUNT SPENT BY USER ONLY
      $data['my_spend'] = 0;
      foreach($time_series_user AS $ds) {
	foreach($ds['data'] AS $d) {
	  $data['my_spend'] += $d['value'];	   
	}
      }
    }

    $data['filters'] = $this->module->get_filters($data['module']['id']); 
    $data['json'] = $this->format_json($time_series);
    $this->load->view("modules/area_chart", $data);
  }

/********************************************************************************
 *                                WRITE METHODS
 ********************************************************************************/
  /* PARAMS: $modid - module to update
   *         $data - array of data to update
   * DESCRP: update the module with the data
   */
  function update_module($modid,$data) {
    // SET MODULE INFO
    $module['name'] = $data['name'];
    unset($data['name']);
    $module['description'] = $data['description'];
    $values = array();
    unset($data['description']);
    foreach($module AS $key=>$value) {
      array_push($values,"$key=".$this->db->escape($module[$key]));
    }
    $values = implode(", ",$values);
    $query = "UPDATE public.module SET $values WHERE id=$modid";
    $this->db->query($query);

    // SET MODULE'S OPTIONS
    foreach($data AS $key=>$value) {
      $opt = explode('_',$key); 
      if(!is_numeric($opt[0])) {
	$this->option->set($opt[0],$opt[1],$value);
      }
    }

    // UPDATE FILTER DATA
    foreach($this->module->get_filters($modid) as $d) {      
      $active = isset($_POST[$d['filter_id']."_active"]) ? 'true' : 'false'; 
      $color = $_POST[$d['filter_id']."_color"];
      $query = "UPDATE public.module_filter SET active='$active', color='$color' WHERE filter_id=$d[filter_id]";
      $this->db->query($query);
    }    
    redirect(site_url("campaign/edit/$modid"));
  }

/********************************************************************************
 *                               ACCESSOR METHODS
 ********************************************************************************/
  /* PARAMS: $modid - id of the module
   *         $userid - id of the user to lookup
   *         $period - number used to determine the number of months to look back at
   *         $frequency - the rate at which transactions should be folded up, i.e. monthly, daily, yearly, etc...
   * DESCRP: constructs a query using the filters associated with a vis and the vis settings for period and frequency of aggregation.
   * RETURN: array(array()) of results data keyed by dataset title and user or module level aggregation
   */ 
  function get_data($module_id, $userid=0, $period, $frequency) {
    // DISCARD INACTIVE FILTERS
    $filters = array();
    foreach($this->module->get_filters($module_id) AS $filter) {
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
	foreach($this->module->get_users($module_id) AS $id) {
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

  /* PARAMS: $modid - module to update
   * DESCRP: print out html input forms for the modules options
   */
  function load_options($module_id) {
    $option = $this->module->get_options($module_id);    
    foreach($option AS $opt) {
      switch($opt['input_type']) {
      case 'select':
	$default_values = explode(',',$opt['default_values']);
	$values = array();
	foreach($default_values AS $df) {
	  list($key,$value) = explode('=>',$df);
	  $values[$key] = $value;
	}
	echo "<div class='module_option'><p>$opt[name]</p>\n<p><select name='$opt[input_type]_$opt[id]'>";
	foreach($values as $key=>$value) {
	  $selected = $opt['value'] == $value ? "selected" : "";
	  echo "<option value='$value'$selected>$key</option>\n";
	}
	echo "</select></p>\n</div>\n";
	break;
      default:
	break;
      }
    }
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
