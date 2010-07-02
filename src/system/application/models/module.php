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
    $this->load->model('option');
  }

  /* PARAMS: $modid - module id
   *         $embed - embed flag
   * DESCRP: load the template for the visualization.
   */  
  function load($modid, $embed=0) {
    // GET MODULE DATA
    $data['module'] = $this->get_module($modid);
    $this->load->model($data['module']['module'],'viz_module');
    $this->viz_module->load($data);
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

  
/********************************************************************************
 *                               ACCESSOR METHODS
 ********************************************************************************/
  /* PARAMS: $modid - module to lookup
   * DESCRP: returns array of option data available to the given module
   */
  function get_options($module_id) {
    $query = "SELECT t2.id, t2.name, t2.input_type, t2.value, t2.default_values FROM public.module AS t1, public.option AS t2, public.module_option AS t3 WHERE t1.id = t3.module_id AND t2.id = t3.option_id AND t1.id = $module_id";
    $result = $this->db->query($query);
    return $result->result_array();  
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
    return $result['is_member'];
  }

}
