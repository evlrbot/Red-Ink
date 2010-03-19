<?php

class RegisterUserCheck extends Controller{
 
  function RegisterUserCheck(){
    parent::Controller();
    $this->load->model("user");
  }
    
  function index(){
    $this->load->library('form_validation');   
    $rules = array(
 		   	   array('field'=>'email','label'=>'E-Mail','rules'=>'required|valid_email'),
 		   	   array('field'=>'password1','label'=>'Password','rules'=>'required|matches[password2]'),
 		   	   array('field'=>'password2','label'=>'Verify Password','rules'=>'required')		       
 		   	 );
    $this->form_validation->set_rules($rules);
    $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
    if($this->form_validation->run() == FALSE){
        $this->load->view('register_user_check');   
    }   
      else{
        $user_data = array('email'=>$this->input->post('email'),'password'=>$this->input->post('password1'));
        $this->user->account_check($user_data); 
      }
  }
}