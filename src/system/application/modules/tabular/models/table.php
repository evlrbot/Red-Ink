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
  
  function load($data,$modid=33) {
    if ($modid==0){
    $userids = $_SESSION['userid']; 
    }
     else{
    $userids = $this->module->get_users($modid);
    $filters=$this->module->get_filters($modid);
    }
     $frequency = 'day';
     $period = 3;
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
     $query .= "GROUP BY date_part('epoch', date_trunc('$frequency',created))*1000 ORDER BY label ASC";
     $result = $this->db->query($query);
     $data['transactions'] = $result->result_array();
     $this->load->view("tabular/table", $data);
   }
  }

}



