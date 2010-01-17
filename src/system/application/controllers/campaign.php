<?php
class Campaign extends Controller {
 
  function Campaign() {
    parent::Controller();
    $this->load->model("auth");
    $this->auth->access();
    $this->load->model("module");
    $this->load->model("user");
  }
  
  function index() {
    $user_data = $this->user->get_account($_SESSION['userid']);
    $this->load->view('site_nav',$user_data);
    $this->load->view('user_nav');
    $this->load->view('user_body_start');
    $data['data'] = $this->module->get_modules();
    $this->load->view('list_modules',$data);
    $this->load->view('user_body_stop');
    $this->load->view('site_foot');
  }

  function create() {
    if($_SERVER['REQUEST_METHOD'] == "POST") {
      // insert model calls here
    }

    $user_data = $this->user->get_account($_SESSION['userid']);
    $this->load->view('site_nav',$user_data);
    $this->load->view('user_nav');
    $this->load->view('user_body_start');
    $this->load->view('create_module');
    $this->load->view('user_body_stop');
    $this->load->view('site_foot');
  }

  function view() {
    $user_data = $this->user->get_account($_SESSION['userid']);
    $this->load->view('site_nav',$user_data);
    $this->load->view('user_nav');
    $this->load->view('user_body_start');
    echo "<p>Mod ID:".$this->input->get_post()."</p>";
    //$data['data'] = $this->module->get_module($this->input->get("id"));
    //$this->load->view('view_module',$data);
    $this->load->view('user_body_stop');
    $this->load->view('site_foot');
  }
}