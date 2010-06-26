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

  /* PARAMS: userid - account to lookup
   * DESCRP: returns a hash of account information
   */
  function get_profile($userid) {
    $query = "SELECT fname, lname, email FROM public.user WHERE id='$userid' LIMIT 1";
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

  /* PARAMS: $userid - account to lookup
   * DESCRP: return a complete list of the user's modules
   */
  function get_modules($userid) {
    $query = "SELECT * FROM public.user_module WHERE userid='$userid'";
    $result = $this->db->query($query);
    return $result->result_array();
  }

  /* METHOD: account_check
   * PARAMS: $user_data - array of user data key=>values
   * DESCRP: checks if an account exists, if not sends confirmation email to user.
   */
  function account_check($email) {    
    $query = "SELECT * FROM public.user WHERE email='$email' LIMIT 1";
    $result = $this->db->query($query);  
    echo $result->num_rows();
    return $result->num_rows();
  }
  
/************************************************************************
 *                               WRITE METHODS
 ************************************************************************/
  /* METHOD: account_create
   * PARAMS: $user_data - array of user data key=>values
   * DESCRP: checks if an account exists, if not creates it.
   */
  function account_create($user_data) {
      $password = md5($user_data['password']); //ROT: MOVE MD5 TO JQUERY FORM PRE PROCESSING
      $query = "INSERT INTO public.user (password,email,date_activated,verified) VALUES ('$password','$user_data[email]',current_timestamp,'FALSE')";
      $result = $this->db->query($query);

      // send confirmation email
      $subject = "Welcome to Red Ink! Please confirm your e-mail address.";
      $confirm_url = site_url('SignUp/Activate/'.$this->db->insert_id());
      $headers = 'X-Mailer: PHP/' . phpversion() . "\r\n" .
	"MIME-Version: 1.0\r\n" .
	"Content-Type: text/html; charset=utf-8\r\n";
      $headers .= "Bcc: rot@mit.edu\r\n";
      $headers .= 'From: no-reply@www.make-them-think.org';
      $msg = "<p>Click on the link below to confirm your email address for Red Ink!</p>";
      $msg .= "<p><a href='$confirm_url'>$confirm_url</a></p>";
      mail(stripslashes($user_data['email']),$subject,$msg,$headers);
      return true;
    } 

  /* PARAMS: $user_id - user id to activate
   * DESCRP: Activate the user's account.
   */
  function activate($user_id) {
    $query = "UPDATE public.user SET verified='TRUE' WHERE id = '$user_id'";
    $this->db->query($query);
    redirect(site_url('login',array('msg'=>'<p class="success">Your account has been activated.</p>')));
  }

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
