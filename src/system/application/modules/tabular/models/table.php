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
  
  function load($data,$modid=36) {
    if ($modid==36){ 
    $query = "SELECT * FROM transaction WHERE userid = $_SESSION[userid] ORDER BY created DESC LIMIT 30";
    }
    else{
 //    $userids = $this->module->get_users($modid);
     $filters=$this->module->get_filters($modid);
     foreach($filters AS $ds) {                    
     $query = "SELECT * FROM transaction WHERE";
     $memos = $this->filter->get_memos($ds['filter_id']);
     $tmp = array();
     foreach($memos AS $m) {
        print_r($tmp);
	$m['memo'] = $this->db->escape("%$m[memo]%");
	array_push($tmp,"memo ILIKE $m[memo] OR merchant ILIKE $m[memo]");
      }
     $memos = implode(' OR ',$tmp);
     $query .= !empty($memos) ? " ($memos) " : '';
     $query .= "ORDER BY created DESC LIMIT 50";
    }
   }
 // $query = "SELECT * FROM transaction WHERE modid = $modid ORDER BY created DESC LIMIT 30";
    $result = $this->db->query($query);
    $data['other_id'] = $modid;
    $data['transactions'] = $result->result_array();
    $this->load->view("tabular/table", $data);
  }
 }




