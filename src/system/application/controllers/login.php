<?php

class Login extends Controller 
{
 
  function Login()
  {
    parent::Controller();	
  }
  
  function index()
  {
    $this->load->view('welcome_message');
  }
  
  function auth()
  {
    if($_SERVER['REQUEST_METHOD'] == "POST") {
      // check l/p
      // return cookie if valid
      // return error if invalid
      if($_POST['username'] == "Username" && $_POST['password'] == "Password") { }
      else {
	// check database for username and encrypted password
	$this->load->database();
	$query = "SELECT * FROM public.user WHERE userid = '$_POST[username]' LIMIT 1";
	$result = $this->db->query($query);
	if(count($result->result()) == 1) {
	  $query = "INSERT INTO public.session (userid,password,email) VALUES ('$email','$passwd','$email')";
	  $result = $this->db->query($query);
	}

      }
      $this->load->view('welcome_message',$data);
    }
    else {
      redirect('Login');
    }
    
  }
}