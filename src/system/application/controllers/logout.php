<?php

class Logout extends Controller 
{
 
  function Logout()
  {
    parent::Controller();	
  }
  
  function index()
  {
    session_start();
    if( isset($_SESSION['userid']) && isset($_SESSION['token']) ) {
      $this->load->database();
      $query = "DELETE FROM public.session WHERE userid = '$_SESSION[userid]' AND token='$_SESSION[token]'";
      $result = $this->db->query($query);
      $_SESSION = array();
      if(isset($_COOKIE[session_name()])) {
	setcookie(session_name(), "", time()-42000,"/");
      }
    }
    session_destroy();
    redirect('login');
  }
}