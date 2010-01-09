<?php

class Me extends Controller 
{
 
  function Me()
  {
    parent::Controller();
    $this->load->model("auth");
    $this->auth->access();
    $this->load->model("user");
  }

  function index()
  {
    $query = "SELECT * FROM public.user WHERE id='$_SESSION[userid]' LIMIT 1";
    $result = $this->db->query($query);
    $user_data = $result->row_array();
    $this->load->view('site_nav',$user_data);
    $this->load->view('user_nav');
    $this->load->view('me');
    $this->load->view('site_foot');
  }

  function account() {
    $user_data = $this->user->account_info();
    $this->load->view('site_nav',$user_data);
    $this->load->view('user_nav');
    $this->load->view('account_info',$user_data);
    $this->load->view('site_foot');
  }
}