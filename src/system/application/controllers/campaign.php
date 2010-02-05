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
    $this->user->load_nav($_SESSION['userid']);
    $this->load->view('user_body_start');
    $this->load->view('list_modules',array('data'=>$this->module->get_modules()));
    $this->load->view('user_body_stop');
    $this->load->view('site_foot');
  }

  function view($modid) {
    $user_data = $this->user->get_account($_SESSION['userid']);
    $this->load->view('site_nav',$user_data);
    $this->user->load_nav($_SESSION['userid']);
    $this->load->view('user_body_start');
    $this->load->view('view_module',array('data'=>$this->module->get_module($modid)));
    $this->load->view('user_body_stop');
    $this->load->view('site_foot');
  }

  function create() {
    if($_SERVER['REQUEST_METHOD'] == "POST") {
      $this->module->create_module($_SESSION['userid'],array($this->input->post('name'),$this->input->post('description')));
    }

    $user_data = $this->user->get_account($_SESSION['userid']);
    $this->load->view('site_nav',$user_data);
    $this->user->load_nav($_SESSION['userid']);
    $this->load->view('user_body_start');
    $this->load->view('create_module');
    $this->load->view('user_body_stop');
    $this->load->view('site_foot');
  }

  function edit($modid) {
    if($_SERVER['REQUEST_METHOD'] == "POST") {
      /*
       * ROT: ADD IN VALIDATION 
       */
      $this->module->update_module($modid,array('name'=>$this->input->post('name'),'description'=>$this->input->post('description')));
      $datasets = $this->module->get_data_sets($modid);
      foreach($datasets AS $ds) {
	$label = $this->input->post("$ds[dataid]_label");
	$query = $this->input->post("$ds[dataid]_query");
	$this->module->update_data_set($ds['dataid'],$label,$query);
      }
    }
    $user_data = $this->user->get_account($_SESSION['userid']);
    $this->load->view('site_nav',$user_data);
    $this->user->load_nav($_SESSION['userid']);
    $this->load->view('user_body_start');
    $mod = $this->module->get_module($modid);
    $mod['data'] = $this->module->get_data_sets($modid);
    //$mod['viz'] = $this->module->get_visualizations($modid);
    $this->load->view('edit_module',$mod);
    $this->load->view('user_body_stop');
    $this->load->view('site_foot');
  }
  
  function delete($modid) {
    $this->module->delete_module($modid);
    redirect("campaign/index");
  }

  function add($modid) {
    $this->module->add_user($_SESSION['userid'],$modid);    
    redirect('campaign/index');
  }

  function remove($modid) {
    $this->module->remove_user($_SESSION['userid'],$modid);        
    redirect('campaign/index');
  }
}