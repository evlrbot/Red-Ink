<?php
class User extends Model {

  function User() {
    parent::Model();
    $this->load->database();
  }

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
  
  function account_info($userid) {
    $query = "SELECT * FROM public.user WHERE id='$userid' LIMIT 1";
    $result = $this->db->query($query);
    return $result->row_array();
  }

  function account_update($user_data) {
    $userid = $user_data['userid'];
    unset($user_data['userid']); // LEAVE JUST THE KEYS TO BE UPDATED
    if(!empty($user_data['password'])) {
      $user_data['password'] = md5($user_data['password']); // MOVE MD5 TO JQUERY FORM PRE PROCESSING
    }
    $values = array();
    foreach($user_data AS $key=>$value) {
      array_push($values,"$key='$value'");
    }
    $values = implode(", ",$values);
    $query = "UPDATE public.user SET $values WHERE id=$userid";
    $this->db->query($query);
  }
  
  function account_api_update($user_data) {

    // NEXT, UPDATE THE API PASSWORDS
    $query = "SELECT id FROM public.api WHERE name = 'Expensify' LIMIT 1";
    $result = $this->db->query($query);
    $row = $result->row_array();
    $apiid = $row->id;
    $query = "IF userid='$userid' AND apiid='$apiid' 
              THEN UPDATE `public.api-login` 
                   SET username='$user_data[expensify_username]', 
                       password='$user_data[expensify_password]'
              ELSE INSERT INTO `public.api-login` (userid,apiid,username,password) 
                   VALUES ($userid,$apiid,$user_data[expensify_username],$user_data[expensify_password])
              END IF";
    $this->db->query($query);    

  }
}
