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
  
  function auth() {
    if($_SERVER['REQUEST_METHOD'] == "POST") {
      $this->load->library('form_validation');   
      $rules = array(
		     array('field'=>'username','label'=>'Username','rules'=>'required'),
		     array('field'=>'password','label'=>'Password','rules'=>'required')
		     );
      $this->form_validation->set_rules($rules);
      $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
      if($this->form_validation->run() == FALSE) {
	$this->load->view('welcome_message');   
      }
      else {
	// CHECK IF USER EXISTS
	$uname = $_POST['username'];
	$passwd = md5($_POST['password']);
	$this->load->database();
	$query = "SELECT * FROM public.user WHERE email='$uname' AND password='$passwd' LIMIT 1";
	$result = $this->db->query($query);
	// IF EXISTS... AUTHORIZE THEM
	if($result->num_rows == 1) {
	  $row = $result->row();
	  $rand = rand(0,getrandmax());
	  $time = time();
	  $query = "INSERT INTO public.session (userid,token,start_time) VALUES ('$row->id','$rand',current_timestamp)";
	  $result = $this->db->query($query);
	  session_start();
	  $_SESSION['token'] = $rand;
	  $_SESSION['userid'] = $row->id;
	  redirect('me');
	}
	// IF NOT EXISTS... DISPLAY ERROR 
	else {
	  $data = array('msg'=>'<p><span class="error">The username or password for that user was incorrect.</span></p>');
	  $this->load->view('welcome_message',$data);
	}
      }
    }
    else {
      redirect('login');
    } 
  }
}