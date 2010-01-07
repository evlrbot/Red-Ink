<?php

class Me extends Controller 
{
 
  function Me()
  {
    parent::Controller();	
  }
  
  function index()
  {
    // ACCESS CONTROL NOTE: MOVE INTO OWN METHOD
    session_start();
    if(isset($_SESSION['userid']) && isset($_SESSION['token'])) {
      $this->load->database();
      $query = "SELECT * FROM public.session WHERE userid='$_SESSION[userid]' AND token='$_SESSION[token]' LIMIT 1";
      $result = $this->db->query($query);
      if($result->num_rows() == 0) {
	redirect('/login');
      } 
    }
    else { 
      redirect('/login'); 
    }
    // END ACCESS CONTROL

    $query = "SELECT * FROM public.user WHERE id='$_SESSION[userid]' LIMIT 1";
    $result = $this->db->query($query);
    $user_data = $result->row_array();
    $this->load->view('site_nav',$user_data);
    $this->load->view('me');
    $this->load->view('site_foot');
  }
}