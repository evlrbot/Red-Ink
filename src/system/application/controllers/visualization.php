<?php
class Visualization extends Controller {
 
  function Visualization() {
    parent::Controller();
    $this->load->model("auth");
    $this->auth->access();
    $this->load->model("user");
    $this->load->model("viz");
    $this->load->model("module");
  }

  function add() {
    $data = $this->user->get_account($_SESSION['userid']);
    $this->load->view('site_nav',$data);
    $this->user->load_nav($_SESSION['userid']);
    $this->load->view('user_body_start');
    $data['vizs'] = $this->viz->get_vizs();
    $this->load->view('list_visualization',$data);
    $this->load->view('user_body_stop');
    $this->load->view('site_foot');
  }
}