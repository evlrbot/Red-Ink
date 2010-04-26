<?php

class Login extends Controller {
  
  function Login() {
    parent::Controller();
    $this->load->model("auth");
    $this->load->model("user");
  }
  
  function index() {
    $this->load->view('site/head');
    $this->load->view('site/nav');
    $this->load->view('templates/login');
    $this->load->view('site/foot');
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
      // FORM DOES NOT VALIDATE...RE-PROMPT
      if($this->form_validation->run() == FALSE) {
	$this->load->view('login');   
      }
      else {
	// FORM VALIDATES...CHECK IF USER EXISTS AND ACCOUNT IS VERIFIED
	if($uid = $this->auth->authorize()) {
	  //USER EXISTS AND ACCOUNT IS VERIFIED...START SESSION
	  $this->auth->start_session($uid);
	  redirect('me');
	}
	else {
	  //USER DOES NOT EXIST... DISPLAY ERROR 
	  $data = array('msg'=>'<p><span class="error">The username or password for that user was incorrect.</span></p>');
	  $this->load->view('login',$data);
	}
      }
    }
    else {
      redirect('login');
    } 
  }
}