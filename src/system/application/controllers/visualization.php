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

  function edit($modid,$modvizid) {

	$data_sets= $this->module->get_data_sets($modid);	

    if($_SERVER['REQUEST_METHOD'] == "POST") {
    	
    	
    	// these need to be moved into model and optimized
    	
    	$q= "DELETE FROM public.mod_viz_data WHERE modvizid=$modvizid";
    	$this->db->query($q);
    	
    	//
    	
    	foreach($data_sets as $d) {	
    	    	
	    	if($moddataid = $this->db->escape($this->input->post($d['dataid']))) {
	    	
				$q= "INSERT INTO public.mod_viz_data (modid, modvizid, moddataid) VALUES ($modid, $modvizid, $moddataid)";
				$this->db->query($q);
			}
			
    	}
    	
    	if($viz_name= $this->db->escape($this->input->post('viz_name_field'))) {
    	
			$q= "UPDATE public.module_visualization SET viz_name=$viz_name WHERE id= $modvizid";
			$this->db->query($q);
		}
    	
		if($this->db->escape($this->input->post('submit2'))) {
		
			$redirect= "/campaign/edit/$modid";
		
			redirect($redirect);
		}
    }
	
	$user= $this->user->get_account($_SESSION['userid']);
	$userid= $_SESSION['userid'];

	$data_set_results= $this->module->get_data_sets_results($data_sets, $userid);

	$template = $this->module->get_template($modvizid);
	
	$mod= $this->module->get_module($modid);
	
	$dataids= $this->module->get_modviz_datasets($modid, $modvizid);

/*	load viz and chart data  */

    $viz = $this->module->get_visualizations($modid, $modvizid);
	
	$viz_datasets= $this->viz->load_viz_datasets($dataids);
	
	$viz_data= $this->viz->load_viz_data($viz_datasets);
	
	$chart_name= $this->module->get_module($modid);
	$chart_name= $chart_name['name'];	
	
	$xml= $this->viz->format_xml($viz_data, $dataids, $chart_name);
	
	$chart_data= array("viz"=>"", "xml"=>$xml, "viz_data"=>$viz_data);

/*  */

	$i= 0;

	while($i< count($data_sets)) {
    
    	$d= $data_sets[$i]["dataid"]; 
    
		$data_sets[$i]['checked']= '';
		
		foreach($dataids as $did) {
					
			if($d== $did["moddataid"]) {
			
				$data_sets[$i]['checked']= 'checked';
			}
		}
		
		$i++;
	}
    
    // need to go through and see which are needed
    
    $data['xml'] = $xml;
	$data['modid'] = $modid;
    $data['user'] = $user;
	$data['data_sets'] = $data_sets;
	$data['template'] = $template;
    $data['mod'] = $mod;
	$data['data_set_results'] = $data_set_results;
	$data['modvizid']= $modvizid;
	$data['dataids']= $dataids;
	$data['chart_data']= $chart_data;
	$data['viz']= $viz;

    $this->load->view('site_nav',$data['user']);	
    $this->user->load_nav($userid);    
    $this->load->view('user_body_start');

    
    $this->load->view('modvizdata',$data);
    $this->load->view('user_body_stop');
    $this->load->view('site_foot');   
  }
}