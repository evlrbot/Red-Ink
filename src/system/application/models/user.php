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

  /* METHOD: account_check
   * PARAMS: $user_data - array of user data key=>values
   * DESCRP: checks if an account exists, if not sends confirmation email to user.
   */
  function account_check($user_data) {
    
    // CHECK IF USER ALREADY EXISTS
    $query = "SELECT * FROM public.user WHERE email='$user_data[email]' LIMIT 1";
    $result = $this->db->query($query);  
    
    // IF USER EMAIL EXISTS...DELIVER ERROR MESSAGE
    if($result->num_rows() != 0) {
      $data = array('msg'=>'<p class="error">That email address is already assigned to a user account.</p>');
 	  $this->load->view('register_user_check.php',$data);
    }    
      // IF USER EMAIL DOES NOT EXIST...CREATE UNVERIFIED USER ACCOUNT & SEND USER CONFIRMATION EMAIL
      else{
      
        $this->user->account_create($user_data);
        
        $this->load->view('register_user_email');
        
        $config=Array(
		  'useragent'=>'Red Ink',  
		  'protocol'=>'postfix',  
		  'mailpath'=>'/usr/sbin/postfix',
		  'smtp_host'=>'',
		  'smtp_user'=>'',  
		  'smtp_pass'=>'',  
		  'smtp_port'=>'25',  
		  'smtp_timeout'=>'5',  
		  'wordwrap'=>TRUE,  
		  'wrapchars'=>'76',
		  'mailtype'=>'html',
		  'charset'=>'iso-8859-1',  
		  'validate'=>TRUE,
		  'priority'=>'1',
		  'crlf'=>"\r\n",
		  'newline'=>"\r\n", 
		  'bcc_batch_mode'=>FALSE, 
		  'bcc_batch_size'=>'200' 
	    );
  
	    $this->load->library('email', $config); 

	    $user_email = $this->input->post('email');
	    date_default_timezone_set('America/New_York');
	    $this->email->from('melva.james@gmail.com', 'Melva James');
	    $this->email->to($user_email);
	    $this->email->subject('RedInk Account Validation');
	    $this->email->message("<p>Thank you for joining RedInk!&nbsp;&nbsp;Please complete your registration by clicking the link below:</p><p><a href=\"http://redink.media.mit.edu/registeruser\">RedInk Account Registration</a><p>Sent ".date("D, j M, Y @ h:i:s A")."</p>");
	    $this->email->send();
//	    echo $this->email->print_debugger();  OPTIONAL EMAIL DELIVERY CHECK
		
	  }
  }

  /* METHOD: account_create
   * PARAMS: $user_data - array of user data key=>values
   * DESCRP: checks if an account exists, if not creates it.
   */
 
  function account_create($user_data) {
  
      $password = md5($user_data['password']); // MOVE MD5 TO JQUERY FORM PRE PROCESSING
      $query = "INSERT INTO public.user (password,email,date_activated,verified) VALUES ('$password','$user_data[email]',current_timestamp,'FALSE')";
      $result = $this->db->query($query);
      return true;
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
  
    //foreach($this->get_modules($userid) AS $mod) {
      //$this->module->load($mod['modid'],$mod['viewid'],$_SESSION['userid']);
    //}
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
