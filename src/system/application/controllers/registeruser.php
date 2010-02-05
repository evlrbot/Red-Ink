<?php

class RegisterUser extends Controller 
{
  
  function RegisterUser()
  {
    parent::Controller();
    $this->load->model("user");
  }
  
  function index()
  {
    $this->load->library('form_validation');   
    $rules = array(
		   array('field'=>'email','label'=>'E-Mail','rules'=>'required|valid_email'),
		   array('field'=>'password1','label'=>'Password','rules'=>'required|matches[password2]'),
		   array('field'=>'password2','label'=>'Verify Password','rules'=>'required')		       
		   );
    $this->form_validation->set_rules($rules);
    $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
    if($this->form_validation->run() == FALSE) {
      $this->load->view('register_user');   
    }
    else {
      $user_data = array('email'=>$this->input->post('email'),'password'=>$this->input->post('password1'));
      if($this->user->account_create(&$user_data)) {
	$data = array('msg'=>'<p><em>You may now login with your new user credentials.</em</p>');
	$this->load->view('login',$data);   
      }
      else {
	$data = array('msg'=>'<p class="error">That email address is already assigned to a user account.</p>');
	$this->load->view('register_user.php',$data);         
      }
    }		
  }
}