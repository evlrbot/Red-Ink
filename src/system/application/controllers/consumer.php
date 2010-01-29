<?php
class Consumer extends Controller {
 
  function Consumer() {
    parent::Controller();
    $this->load->model("auth");
    $this->auth->access();
    $this->load->model("user");
  }
  
  function index() {
    $data = $this->user->get_account($_SESSION['userid']);
    $this->load->view('site_nav',$data);
    $this->user->load_nav($_SESSION['userid']);
    $this->load->view('user_body_start');
    $data['users'] = $this->user->get_accounts();
    $this->load->view('list_users',$data);
    $this->load->view('user_body_stop');
    $this->load->view('site_foot');
  }
}