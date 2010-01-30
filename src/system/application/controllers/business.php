<?php
class Business extends Controller {
 
  function Business() {
    parent::Controller();
    $this->load->model("auth");
    $this->auth->access();
    $this->load->model("user");
    $this->load->model("biz");
  }

  function index() {
    $data = $this->user->get_account($_SESSION['userid']);
    $this->load->view('site_nav',$data);
    $this->user->load_nav($_SESSION['userid']);
    $this->load->view('user_body_start');
    $data['bizs'] = $this->biz->get_bizs();
    $this->load->view('list_bizs',$data);
    $this->load->view('user_body_stop');
    $this->load->view('site_foot');
  }

  function add() {
    $data = $this->user->get_account($_SESSION['userid']);
    $this->load->view('site_nav',$data);
    $this->user->load_nav($_SESSION['userid']);
    $this->load->view('user_body_start');
    $this->load->view('register_business');
    $this->load->view('user_body_stop');
    $this->load->view('site_foot');
  }
}