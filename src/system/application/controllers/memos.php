<?php
class Memo extends Controller {
 
  function Memos() {
    parent::Controller();
    $this->load->model("auth");
    $this->auth->access();
    $this->load->model("memo");
    $this->load->model("user");
  }
  
  function index() {
    redirect("/business/index");
  }
    
  function add($bizid) {
    $user_data = $this->user->get_account($_SESSION['userid']);
    $this->load->view('site_nav',$user_data);
    $this->user->load_nav($_SESSION['userid']);
    $this->load->view('user_body_start');
    $this->load->view('add_memo',array('bizid'=>$bizid));
    $this->load->view('user_body_stop');
    $this->load->view('site_foot');
  }
}