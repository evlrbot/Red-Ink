<?php
class Campaign extends Controller {
 
  function Campaign() {
    parent::Controller();
    $this->load->model("auth");
    $this->auth->access();
    $this->load->model("module");
    $this->load->model("user");
    $this->load->model("data");
    $this->load->model("viz");
    $this->load->model("filter");
  }
  
  function index() {
    $this->load->view('site/head');
    $this->load->view('site/nav',$this->user->get_account($_SESSION['userid']));
    $this->load->view('site/body_start');
    $this->load->view('list_modules',array('data'=>$this->module->get_modules()));
    $this->load->view('site/body_stop');
    $this->load->view('site/foot');
  }

  function view($modid) {
    $this->load->view('site/head');
    $this->load->view('site/nav',$this->user->get_account($_SESSION['userid']));
    $this->load->view('site/body_start');
    $this->load->view('module/view',array('data'=>$this->module->get_module($modid)));
    $this->load->view('site/body_stop');
    $this->load->view('site/foot');
  }

  function create() {
    if($_SERVER['REQUEST_METHOD'] == "POST") {
      $this->module->create_module($_SESSION['userid'],array($this->input->post('name'),$this->input->post('description')));
    }

    $this->load->view('site/head');
    $this->load->view('site/nav',$this->user->get_account($_SESSION['userid']));
    $this->load->view('site/body_start');
    $this->load->view('create_module');
    $this->load->view('site/body_stop');
    $this->load->view('site/foot');
  }

  function edit($modid) {
    if($_SERVER['REQUEST_METHOD'] == "POST") {
      $this->module->update_module($modid,array('name'=>$this->input->post('name'),'description'=>$this->input->post('description')));
    }

    $this->load->view('site/head');
    $this->load->view('site/nav',$this->user->get_account($_SESSION['userid']));
    $this->load->view('site/body_start');

    $mod = $this->module->get_module($modid);
    $mod['filters'] = $this->module->get_filters($modid);
    $mod['viz'] = $this->module->get_visualizations($modid);
    $dataids= array();
    foreach($mod['viz'] as $v) {
      $modvizdata[$v['modvizid']] = $this->viz->get_datasets($v['modvizid']);
    }    
    $mod['modvizdata'] = $modvizdata;
    $this->load->view('modules/edit',$mod);
    $this->load->view('site/body_stop');
    $this->load->view('site/foot');
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

  function add_filter($module_id,$filter_id=0) {
    if($filter_id) {
      $this->module->add_filter($module_id,$filter_id);
      redirect(site_url("campaign/edit/$module_id"));
    }
    $this->load->view('site/head');
    $this->load->view('site/nav',$this->user->get_account($_SESSION['userid']));
    $this->load->view('site/body_start');
    $data['filters'] = $this->filter->get_filters();
    $data['module_id'] = $module_id;
    $this->load->view('modules/add_filter',$data);
    $this->load->view('site/body_stop');
    $this->load->view('site/foot');
  }
}