<?php
class Auth extends Model {

  function Auth() {
    parent::Model();
    session_start();
    $this->load->database();
  }

  function authorize() {
    $uname = $this->input->post('username');
    $passwd = md5($this->input->post('password')); // MOVE MD5 TO JS PRIOR TO SUBMITTING THE FORM
    $query = "SELECT * FROM public.user WHERE email='$uname' AND password='$passwd' AND verified='TRUE' LIMIT 1";
    $result = $this->db->query($query); 
    $row = $result->row();
    return $result->num_rows ? $row->id : false;
  }

  function verify_account() {
    $query = "INSERT INTO public.user (verified) VALUES ('TRUE')";
    $result = $this->db->query($query);
  }
  
  function start_session($uid) {
    $_SESSION['userid'] = $uid;
    $_SESSION['token'] = $token = rand(0,getrandmax());
    $query = "INSERT INTO public.session (userid,token,start_time) VALUES ('$uid','$token',current_timestamp)";
    $result = $this->db->query($query);
  }

  function access() {
    if(isset($_SESSION['userid']) && isset($_SESSION['token'])) {
      $query = "SELECT * FROM public.session WHERE userid='$_SESSION[userid]' AND token='$_SESSION[token]' LIMIT 1";
      $result = $this->db->query($query);
      if($result->num_rows() == 0) {
	redirect('/login');
      } 
    }
    else { 
      redirect('/login'); 
    }
  }

  function destroy_session() {
    if( isset($_SESSION['userid']) && isset($_SESSION['token']) ) {
      $query = "DELETE FROM public.session WHERE userid = '$_SESSION[userid]' AND token='$_SESSION[token]'";
      $result = $this->db->query($query);
      $_SESSION = array();
      if(isset($_COOKIE[session_name()])) {
	setcookie(session_name(), "", time()-42000,"/");
      }
    }
    session_destroy(); 
  }
}
