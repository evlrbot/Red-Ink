<?php
class Module extends Model {
/********************************************************************************
 *                                 CONSTRUCTOR
 ********************************************************************************/
  function Module() {
    parent::Model();
    $this->load->database();
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
    $query = "INSERT INTO public.user_module (userid,modid,viewid) VALUES ($userid,$modid,1)";
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
  /* PARAMS: $modid - id of the module to load
   *         $viewid - id of the view to load
   *         $userid - id of the user loading the module/view
   * DESCRP: Loads the appropriate module/view/data given the above params
   */
  function load($modid,$viewid,$userid) {
    $data['mod'] = $this->get_module($modid);
    $data['data'] = $this->get_data_sets_results($this->get_data_sets($modid),$userid);  
    if(count($data['data']) > 0) {
      $template = $this->get_template($viewid);
      $this->load->view("modules/$template",$data);
    }
  }

 /* PARAMS: $modid
   * DESCRP: return associative array of data ids, labels and query strings
   */
  function get_data_sets($modid) {
    $query = "SELECT t2.name, t2.id AS dataid, t2.query FROM public.module_data AS t1, public.data AS t2 WHERE modid=$modid AND t1.dataid = t2.id";
    $result = $this->db->query($query);
    return $result->result_array();
  }

  /* PARAMS: $modid
   * DESCRP: return associative array of data labels and data result arrays
   */
  function get_data_sets_results($datasets,$userid) {
    $data = array();
    foreach($datasets AS $ds) {
      $result = $this->db->query($ds['query'],array($userid));
      $data[$ds['name']] = $result->result_array();
    }
    return $data;
  }

  /* PARAMS: $viewid
   * DESCRP: For a given view returns the view's associate template file path
   */
  function get_template($viewid) {
    $query = "SELECT template FROM view WHERE id=$viewid LIMIT 1";
    $result = $this->db->query($query);
    $tmp = $result->row_array();
    return $tmp['template'];
  }

  /* PARAMS: void
   * DESCRP: return list of all modules
   */
  function get_modules() {
    $query = "SELECT * FROM public.module";
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
 
  /* PARAMS: $dataid
   * DESCRP: return the constraint strings for the given data
   */
  function get_constraints($dataid) {
    $query = "SELECT t2.constraint FROM public.data_constraint AS t1, public.constraint AS t2 WHERE t1.dataid=$dataid AND t2.id = t1.constraintid";
    $result = $this->db->query($query);
    return $result->result_array();    
  }

  /* PARAMS: $viewid
   * DESCRP: return an array of data for the view
   */
/*
  function get_view_data($modid,$viewid,$userid) {
    $query = "SELECT dataid,name FROM public.view_data AS t1, public.data AS t2 WHERE t1.viewid='$viewid' AND t1.modid='$modid' AND t2.id=dataid";
    $result = $this->db->query($query);
    $datas = $result->result_array();
    $tmp = array();
    foreach($datas AS $data) {
      $query = "SELECT \"constraint\" FROM public.data_constraint AS t1, public.constraint AS t2 WHERE dataid='$data[dataid]' AND t2.id=constraintid";
      $result = $this->db->query($query);
      $sql = $result->row_array();
      $result = $this->db->query($sql['constraint'],array($userid));
      $tmp[$data['name']] = $result->result_array();
    }
    return $tmp;
  }
*/  
}