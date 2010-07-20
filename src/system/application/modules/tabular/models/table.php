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

class Table extends model {

  function Table() {
    parent::model();
    $this->load->model('option');
  } 
  
  function load($data) {
    // option for determining to show only the user's data or all data. 
    // if fitlers are present use them, if not show all unfiltered transactions

    // GET MODULE OPTIONS
    $data['options'] = array();
    $options = $this->module->get_options($data['module']['id']);
    foreach($options AS $opt) {
      $data['options'][$opt['name']] = $opt['value'];
    }

    // ONLY GET USER'S TRANSACTIONS
    $data['members'] = $_SESSION['userid'];
    $data['transactions'] = $this->get_data($data);

    $data['json_trans'] = json_encode($data['transactions']);
    $this->load->view('tabular/json_page',$data);

    $this->load->view("tabular/table", $data);

//   LOAD PAGES CLASS TO FORMAT TRANSACTIONS DATA INTO JSON
//     $this->load->module("tabular/pages");
//     $this->pages->index($data);
  }
  
  function get_data($data) {
    // CHECK TO SEE IF OTHER MODULE IS PASSING ID TO LOAD FILTERS
    // DISCARD INACTIVE FILTERS
    $filters = array();
    if (isset($data['parent_module_id'])) {
      foreach($this->module->get_filters($data['other_id']) AS $filter) {
        if($filter['active'] == 't')
        array_push($filters, $filter);
      }
    }
    foreach($this->module->get_filters($data['module']['id']) AS $filter) {
      if($filter['active'] == 't') {
	array_push($filters,$filter);
      }      
    }

    $period = $data['options']['Period'];

    $results = array(); // ONE INDEX OF TIME SERIES DATA PER FILTER
    if(count($filters)) {
      foreach($filters AS $ds) {                   
	// CONSTRUCT SELECT STATEMENT
	$query = "SELECT *, abs(round(amount/100.0,2)) AS value FROM public.transaction ";
	
	// APPEND PERIOD PARAM
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
	$query .= " AND (userid=$data[members]) ";
	
	// AGGREGATE BY...
	$query .= "ORDER BY created ASC";
	$result = $this->db->query($query);
	
	// PREPARE RETURN RESULTS
	$results[$ds['name']]['data'] = $result->result_array();
	$results[$ds['name']]['active'] = $ds['active'];
	$results[$ds['name']]['color'] = $ds['color'];
      }
    }
    else {
      // CONSTRUCT SELECT STATEMENT
      $query = "SELECT *, abs(round(amount/100.0,2)) AS value FROM public.transaction ";
      
      // APPEND PERIOD PARAM
      $query .= "WHERE (created > current_date - interval '$period months')";
      
      // LIMIT USERS TO LOOK AT
      $query .= " AND (userid=$data[members]) ";
      
      // AGGREGATE BY...
      $query .= "ORDER BY created ASC";
      $result = $this->db->query($query);
      
      // PREPARE RETURN RESULTS
      $results['user_only']['data'] = $result->result_array();
      $results['user_only']['active'] = '';
      $results['user_only']['color'] = '';
    }
    return $results;
  }
  
  function load_options() {}
 }




