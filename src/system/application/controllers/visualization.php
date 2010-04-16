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

  function add($modid,$vizid=0) {
    if($modid && $vizid) { // ADD VIZ 2 MOD
      $this->viz->add($modid,$vizid);
      redirect("/campaign/edit/$modid");
    }
	elseif($modid) { // LIST VIZS
      $data['modid'] = $modid;
      $data['user'] = $this->user->get_account($_SESSION['userid']);
      $this->load->view('site_nav',$data['user']);
      $this->user->load_nav($_SESSION['userid']);
      $this->load->view('user_body_start');
      
	  $this->viz->load_sample_vizs($modid);
      
      $this->load->view('user_body_stop');
      $this->load->view('site_foot');    
    }
    else {} // NOTHING WAS PASSED, DO NOTHING
  }
   
  function remove($modid,$modvizid) {
    if($modid && $modvizid) { // ADD VIZ 2 MOD
      $this->viz->remove($modvizid);
      redirect("/campaign/edit/$modid");
    }
  }

  function edit($modid,$modvizid) {
    $data_sets= $this->module->get_data_sets($modid); 
    if($_SERVER['REQUEST_METHOD'] == "POST") {
	  $this->viz->save_mod_viz_form($modid, $modvizid, $data_sets);
    }
    $data_set_results = $this->viz->get_dataset_results($modvizid,$_SESSION['userid']);  // *NEW* THE REAL TIME SERIES DATA QUERY
    // SET THE ACTIVE DATASETS FOR THIS VISUALIZATION FOR THIS MODULE
	$data_sets= $this->viz->format_viz_datasets($modvizid, $data_sets);
    $json = $this->viz->format_json($data_set_results, $data_sets);                                  // FORMAT TIME SERIES DATA INTO FLOT JSON
    // PREPARE DATA TO LOAD IN VIEW
    $data['modid'] = $modid;
    $data['modvizid'] = $modvizid;
    $data['json'] = $json;
    $data['data_sets'] = $data_sets;
    $data['viz'] = $this->module->get_visualization($modvizid);  // get the info for this vis for this module
    $this->load->view('site_nav',$this->user->get_account($_SESSION['userid']));	
    $this->user->load_nav($_SESSION['userid']);    
    $this->load->view('user_body_start');
    $this->load->view('mod_viz_data',$data);
    $this->load->view('user_body_stop');
    $this->load->view('site_foot');   
  }

  function json($modid,$modvizid) {
  
    $data_set_results = $this->viz->get_dataset_results($modvizid,$_SESSION['userid']);  // *NEW* THE REAL TIME SERIES DATA QUERY
    $json = $this->viz->format_json($data_set_results);                                  // FORMAT TIME SERIES DATA INTO FLOT JSON 
    echo $json;
  }
}