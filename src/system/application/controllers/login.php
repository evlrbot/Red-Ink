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
    // VALIDATE FORM
    if($_SERVER['REQUEST_METHOD'] == "POST") {
      $this->load->library('form_validation');   
      $rules = array(
		     array('field'=>'username','label'=>'Username','rules'=>'required|valid_email'),
		     array('field'=>'password','label'=>'Password','rules'=>'required')
		     );
      $this->form_validation->set_rules($rules);
      $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
      // FORM DID NOT VALIDATE RE-PROMPT
      if($this->form_validation->run() == FALSE) {
	$this->load->view('welcome_message');   
      }
      else {
	// CHECK IF USER EXISTS
	$this->load->model("auth");
	if($uid = $this->auth->authorize()) {
	  $this->auth->start_session($uid);
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