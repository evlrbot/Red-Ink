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
      $data['vizs'] = $this->viz->get_vizs();
      $this->load->view('list_visualization',$data);
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

  function edit($modid,$vizid,$modvizid) {

	$user= $this->user->get_account($_SESSION['userid']);
	$userid= $_SESSION['userid'];
	$data_sets= $this->module->get_data_sets($modid);	
	$data_set_results= $this->module->get_data_sets_results($data_sets, $userid);
	$template = $this->module->get_template($vizid);
	$mod= $this->module->get_module($modid);
    
	$xml= "<chart caption='".htmlentities($modid['name'])."' xAxisName='Month' yAxisName='$' showValues='0' numberPrefix='$' canvasbgColor='FFFFFF' canvasBorderColor='000000' canvasBorderThickness='2'>";
	$colors = array("FF0000","AA0000","0000FF","0E2964");
	date_default_timezone_set('America/New_York');
	$keys = array_keys($data_set_results); 
	
	// take a single dataset
	$data_set_results= $data_set_results[$keys[0]];
	
	// iterate through to find month/$ pairs
	foreach($data_set_results as $d) {
	
		$xml .= "<set label= '" .$d["label"]. "' value='" .abs($d["value"]). "'/>";
	}
	
	$xml.= "</chart>";
    
    $data['xml'] = $xml;
	$data['modid'] = $modid;
    $data['user'] = $user;
	$data['data_sets'] = $data_sets;
	$data['template'] = $template;
    $data['mod'] = $mod;
	$data['data_set_results'] = $data_set_results;
	$data['vizid']= $vizid;
	
    $this->user->load_nav($userid);    
    $this->load->view('site_nav',$data['user']);
    $this->load->view('user_body_start');    
    $this->load->view('modvizdata',$data);
    $this->load->view('user_body_stop');
    $this->load->view('site_foot');   
  }
}