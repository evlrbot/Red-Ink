<?php

class Logout extends Controller 
{
 
  function Logout()
  {
    parent::Controller();
  }
  
  function index()
  {
    $this->load->model("auth");
    $this->auth->destroy_session();
    redirect('login');
  }
}