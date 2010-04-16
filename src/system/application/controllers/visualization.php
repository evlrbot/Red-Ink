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
      // these need to be moved into model and optimized
      $q= "DELETE FROM public.mod_viz_data WHERE modvizid=$modvizid";
      $this->db->query($q);
      foreach($data_sets as $d) {	
	if($moddataid = $this->db->escape($this->input->post($d['dataid']))) {
	  // needs optimization
	  $moddataid_color= $d['dataid'] . "_color";
	  $moddataid_color= $_POST[$moddataid_color];
	  $q= "INSERT INTO public.mod_viz_data (modid, modvizid, moddataid, moddataid_color) VALUES ($modid, $modvizid, $moddataid, '$moddataid_color')";
	  $this->db->query($q);
	}
      }
      $viz_name= $this->db->escape($this->input->post('viz_name_field'));
      $q= "UPDATE public.module_visualization SET viz_name=$viz_name WHERE id= $modvizid";
      $this->db->query($q);
      $viz_stacked= $this->db->escape($this->input->post('viz_stacked_field'));
      $q= "UPDATE public.module_visualization SET stacked= $viz_stacked WHERE id= $modvizid";
      $this->db->query($q);
      if($this->db->escape($this->input->post('submit2'))) {
	$redirect= "/campaign/edit/$modid";
	redirect($redirect);
      }
    }
    $data_set_results = $this->viz->get_dataset_results($modvizid,$_SESSION['userid']);  // *NEW* THE REAL TIME SERIES DATA QUERY
    $json = $this->viz->format_json($data_set_results);                                  // FORMAT TIME SERIES DATA INTO FLOT JSON

    // SET THE ACTIVE DATASETS FOR THIS VISUALIZATION FOR THIS MODULE
    for($i=0; $i<count($data_sets); $i++) {
      foreach($this->viz->get_datasets($modvizid) AS $ds) {
	if($data_sets[$i]["dataid"] == $ds["moddataid"]) {
	  $data_sets[$i]["checked"] = 'checked';
	  $data_sets[$i]["color"]= $ds['moddataid_color'];
	}
      }
    }

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