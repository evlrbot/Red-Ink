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
    $data['modules'] = array();
    $mods = $this->user->get_modules($_SESSION['userid']);
    foreach($mods AS $mod) {
      array_push($data['modules'],$this->module->get_module($mod['modid']));
    }
    $this->load->view('user_nav',$data);
    $this->load->view('user_body_start');
    $this->load->view('list_modules',array('data'=>$this->module->get_modules()));
    $this->load->view('user_body_stop');
    $this->load->view('site_foot');
  }

  function view($modid) {
    $user_data = $this->user->get_account($_SESSION['userid']);
    $this->load->view('site_nav',$user_data);
    $this->load->view('user_nav');
    $this->load->view('user_body_start');
    $user_data['modules'] = array();
    $this->load->view('view_module',$user_data);
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
}