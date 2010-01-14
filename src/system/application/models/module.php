<?php
class Module extends Model {

  function Module() {
    parent::Model();
    $this->load->database();
  }

  /* PARAMS: $userid - user to lookup
   *         $modid - module to lookup
   * DESCRP: add module to user account
   */
  function add_user($userid,$modid) {
    $query = "INSERT INTO public.user_module (userid,modid) VALUES ($userid,$modid)";
    $this->db->query($query);
  }
  
  function load($viewid,$userid) {
    $data['data'] = $this->get_view_data($viewid,$userid);
    $template = $this->get_template($viewid);
    $this->load->view("modules/$template",$data);
  }

  function get_template($viewid) {
    $query = "SELECT template FROM view WHERE id=$viewid LIMIT 1";
    $result = $this->db->query($query);
    $tmp = $result->row_array();
    return $tmp['template'];
  }
  
  /* PARAMS: $viewid
   * DESCRP: return an array of data for the view
   */
  function get_view_data($viewid,$userid) {
    $query = "SELECT dataid,name FROM public.view_data AS t1, public.data AS t2 WHERE t1.viewid='$viewid' AND t2.id=dataid";
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
}