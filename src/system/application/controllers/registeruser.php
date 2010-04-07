<?php

class RegisterUser extends Controller{
 
  function RegisterUser(){
    parent::Controller();
    $this->load->model("user");
    $this->load->model("auth");
  }
    
  function index(){
    $this->auth->verify_account();
    $data = array('msg'=>'<p><em>You may now login with your new user credentials.</em</p>');
 	$this->load->view('login',$data);
  }
}