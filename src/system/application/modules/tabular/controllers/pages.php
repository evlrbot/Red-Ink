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

class Pages extends Controller {
/********************************************************************************
 *                                 CONSTRUCTOR
 ********************************************************************************/
  function Pages() {
    parent::Controller();
  }

  function index($data) {
   $this->load->model('tabular');
   $data['json_trans'] = json_encode($tabular->get_data($data));
   $this->load->view('tabular/json_page', $data);
 }
/*
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
 */

 }
