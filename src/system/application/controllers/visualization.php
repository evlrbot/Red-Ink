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
      $this->load->view('site/head');
      $this->load->view('site/nav',$data['user']);
      $this->load->view('site/body_start');
      $this->viz->load_sample_vizs($modid);
      $this->load->view('site/body_stop');
      $this->load->view('site/foot');    
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
    $data_sets = $this->module->get_data_sets($modid); 
    if($_SERVER['REQUEST_METHOD'] == "POST") {
      $this->viz->save_mod_viz_form($modid, $modvizid, $data_sets);
    }
    if($viz_data_sets = $this->viz->get_datasets($modvizid)) {
      $data['timeframe'] = $viz_data_sets[0]['timeframe'];
      $data['interval'] = $viz_data_sets[0]['interval'];
    }
    else {
      $data['timeframe'] = 'year';
      $data['interval'] = 'month';
    }

    $data['user'] = $this->user->get_account($_SESSION['userid']);
    $data['modid'] = $modid;
    $data['modvizid'] = $modvizid;
    $data['data_sets'] = $this->viz->format_viz_datasets($modvizid, $data_sets);
    $data['viz'] = $this->viz->get_visualization($modvizid);  // get the info for this vis for this module
    $data['model_viz'] = $this->viz;

    $this->load->view('site/head');
    $this->load->view('site/nav',$data['user']);
    $this->load->view('site/body_start');
    $this->load->view('mod_viz_data',$data);
    $this->load->view('site/body_stop');
    $this->load->view('site/foot');   
  }

  function json($modid,$modvizid) {  
    $data_set_results = $this->viz->get_dataset_results($modvizid,$_SESSION['userid']);  // *NEW* THE REAL TIME SERIES DATA QUERY
    $json = $this->viz->format_json($data_set_results);                                  // FORMAT TIME SERIES DATA INTO FLOT JSON 
    echo $json;
  }
}