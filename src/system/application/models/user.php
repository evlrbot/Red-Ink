<?php
class User extends Model {

/************************************************************************
 *                            CONSTRUCTOR METHODS
 ************************************************************************/
  /* METHOD: User
   * PARAMS: void
   * DESCRP: constructor
   */
  function User() {
    parent::Model();
    $this->load->database();
    $this->load->model('module');
  }

  /* METHOD: account_create
   * PARAMS: $user_data - array of user data key=>values
   * DESCRP: checks if an account exists, if not creates it.
   */
  function account_create($user_data) {
    // CHECK IF USER ALREADY EXISTS
    $query = "SELECT * FROM public.user WHERE email='$user_data[email]' LIMIT 1";
    $result = $this->db->query($query);
    // IF NOT... ADD USER
    if($result->num_rows() == 0) {
      $password = md5($user_data['password']); // MOVE MD5 TO JQUERY FORM PRE PROCESSING
      $query = "INSERT INTO public.user (password,email,date_activated) VALUES ('$password','$user_data[email]',current_timestamp)";
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

  /* PARAMS: userid - account to lookup
   * DESCRP: returns a hash of account information
   */
  function get_account($userid) {
    $query = "SELECT * FROM public.user WHERE id='$userid' LIMIT 1";
    $result = $this->db->query($query);
    return $result->row_array();
  }

  /* PARAMS: void
   * DESCRP: returns hash of data for all user accounts
   */
  function get_accounts() {
    $query = "SELECT * FROM public.user ORDER BY email ASC";
    $result = $this->db->query($query);
    return $result->result_array();
  }

  /* PARAMS: $userid - account to lookup
   *         $apiid - API to lookup
   * DESCRP: return the user's login for the given API
   */
  function get_api_login($userid,$apiid) {
    $result = $this->db->query("SELECT username,password FROM public.api_login WHERE userid='$userid' AND apiid='$apiid' LIMIT 1");
    return $result->row_array();
  }

  /* PARAMS: $userid - account to lookup
   * DESCRP: return a complete list of the user's transactions
   */
  function get_transactions($userid) {
    $query = "SELECT * FROM public.transaction WHERE userid='$userid'";
    $result = $this->db->query($query);
    return $result->result_array();
  }

  function get_modules($userid) {
    $query = "SELECT * FROM public.user_module WHERE userid='$userid'";
    $result = $this->db->query($query);
    return $result->result_array();
  }

  function load_modules($userid) {
    foreach($this->get_modules($userid) AS $mod) {
      $this->module->load($mod['modid'],$mod['viewid'],$_SESSION['userid']);
    }
  }
  
  function load_nav($userid) {
    $data['modules'] = array();
    $mods = $this->user->get_modules($userid);
    foreach($mods AS $mod) {
      array_push($data['modules'],$this->module->get_module($mod['modid']));
    }
    $this->load->view('user_nav',$data);
  }

/************************************************************************
 *                               WRITE METHODS
 ************************************************************************/
  /* PARAMS: $user_data - array of user data to update
   * DESCRP: Update's the user's account profile
   */
  function update($user_data) {
    $userid = $user_data['userid'];
    unset($user_data['userid']); // LEAVE JUST THE KEYS TO BE UPDATED
    if(empty($user_data['password'])) {
      unset($user_data['password']);
    }
    else {
      $user_data['password'] = md5($user_data['password']); // MOVE MD5 TO JQUERY FORM PRE PROCESSING
    }
    $values = array();
    foreach($user_data AS $key=>$value) {
 	  $value = $this->db->escape($value);
      array_push($values,"$key=$value");
    }
    $values = implode(", ",$values);
    $query = "UPDATE public.user SET $values WHERE id=$userid";
    $this->db->query($query);
  }

  /* PARAMS: $user_data - the user's login data for a given API
   * DESCRP: update the user's API login data
   */
  function update_api_login($user_data) {
    $query = "SELECT * FROM public.api_login WHERE userid='$user_data[userid]' AND apiid='$user_data[apiid]'";
    $result = $this->db->query($query);
    if($result->num_rows()) {
      $query = "UPDATE public.api_login 
                SET username='$user_data[username]', 
                    password='$user_data[password]' 
                WHERE userid='$user_data[userid]' 
                AND apiid='$user_data[apiid]'";
    }
    else {
      $query = "INSERT INTO public.api_login (username,password,userid,apiid)
                VALUES ('$user_data[username]', 
                        '$user_data[password]', 
                        '$user_data[userid]', 
                        '$user_data[apiid]')";
    }
    return $this->db->query($query);
  }
}
