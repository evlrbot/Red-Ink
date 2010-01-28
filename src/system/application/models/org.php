<?php
class Org extends Model {

/************************************************************************
 *                            CONSTRUCTOR METHODS
 ************************************************************************/
  /* METHOD: Org
   * PARAMS: void
   * DESCRP: constructor
   */
  function Org() {
    parent::Model();
    $this->load->database();
    $this->load->model('module');
  }

  /* METHOD: account_create
   * PARAMS: $user_data - array of user data key=>values
   * DESCRP: checks if an account exists, if not creates it.
   */
  function account_create(org_data) {
    // CHECK IF USER ALREADY EXISTS
    $query = "SELECT * FROM public.org WHERE email='$org_data[email]' LIMIT 1";
    $result = $this->db->query($query);
    // IF NOT... ADD ORGANIZATION
    if($result->num_rows() == 0) {
      $password = md5($org_data['password']); // MOVE MD5 TO JQUERY FORM PRE PROCESSING
      $query = "INSERT INTO public.org (password,email,date_activated) VALUES ('$password','$org_data[email]',current_timestamp)";
      $result = $this->db->query($query);
      return true;
    }
    else {
      return false;
    }
  }

/************************************************************************
 *                           ACCESSOR METHODS
 ************************************************************************/

  /* PARAMS: org_id - account to lookup
   * DESCRP: returns a hash of account information
   */
  function get_account($org_id) {
    $query = "SELECT * FROM public.org WHERE id='$org_id' LIMIT 1";
    $result = $this->db->query($query);
    return $result->row_array();
  }

  /* PARAMS: $org_id - account to lookup
   *         $apiid - API to lookup
   * DESCRP: return the organization's login for the given API
   */
  function get_api_login($org_id,$apiid) {
    $result = $this->db->query("SELECT username,password FROM public.api_login WHERE org_id='$org_id' AND apiid='$apiid' LIMIT 1");
    return $result->row_array();
  }

  /* PARAMS: $org_id - account to lookup
   * DESCRP: return a complete list of the organization's transactions
   */
  function get_transactions($org_id) {
    $query = "SELECT * FROM public.transaction WHERE org_id='$org_id'";
    $result = $this->db->query($query);
    return $result->result_array();
  }

  function get_modules($org_id) {
    $query = "SELECT * FROM public.org_module WHERE org_id='$org_id'";
    $result = $this->db->query($query);
    return $result->result_array();
  }

  function load_modules($org_id) {
    foreach($this->get_modules($org_id) AS $mod) {
      $this->module->load($mod['modid'],$mod['viewid'],$_SESSION['org_id']);
    }
  }
  
  function load_nav($org_id) {
    $data['modules'] = array();
    $mods = $this->org->get_modules($orgid);
    foreach($mods AS $mod) {
      array_push($data['modules'],$this->module->get_module($mod['modid']));
    }
    $this->load->view('org_nav',$data);
  }

/************************************************************************
 *                               WRITE METHODS
 ************************************************************************/
  /* PARAMS: $org_data - array of organization data to update
   * DESCRP: Update's the organization's account profile
   */
  function update($org_data) {
    $org_id = $org_data['org_id'];
    unset($org_data['org_id']); // LEAVE JUST THE KEYS TO BE UPDATED
    if(empty($org_data['password'])) {
      unset($org_data['password']);
    }
    else {
      $org_data['password'] = md5($org_data['password']); // MOVE MD5 TO JQUERY FORM PRE PROCESSING
    }
    $values = array();
    foreach($org_data AS $key=>$value) {
 	  $value = $this->db->escape($value);
      array_push($values,"$key=$value");
    }
    $values = implode(", ",$values);
    $query = "UPDATE public.org SET $values WHERE id=$org_id";
    $this->db->query($query);
  }

  /* PARAMS: $org_data - the organization's login data for a given API
   * DESCRP: update the organization's API login data
   */
  function update_api_login($org_data) {
    $query = "SELECT * FROM public.api_login WHERE org_id='$org_data[org_id]' AND apiid='$org_data[apiid]'";
    $result = $this->db->query($query);
    if($result->num_rows()) {
      $query = "UPDATE public.api_login 
                SET username='$org_data[username]', 
                    password='$org_data[password]' 
                WHERE org_id='$org_data[org_id]' 
                AND apiid='$org_data[apiid]'";
    }
    else {
      $query = "INSERT INTO public.api_login (username,password,userid,apiid)
                VALUES ('$org_data[username]', 
                        '$org_data[password]', 
                        '$org_data[userid]', 
                        '$org_data[apiid]')";
    }
    return $this->db->query($query);
  }
}
