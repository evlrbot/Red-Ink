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
    	
    	$q= "DELETE FROM public.mod_viz_data WHERE modvizid=$modvizid";
    	$this->db->query($q);
    	
    	foreach($data_sets as $d) {	
    	    	
	    	if($moddataid = $this->db->escape($this->input->post($d['dataid']))) {
	    	
				$q= "INSERT INTO public.mod_viz_data (modid, modvizid, moddataid) VALUES ($modid, $modvizid, $moddataid)";
				$this->db->query($q);
			}
			
    	}
    }


	$user= $this->user->get_account($_SESSION['userid']);
	$userid= $_SESSION['userid'];

	$data_set_results= $this->module->get_data_sets_results($data_sets, $userid);

	$template = $this->module->get_template($modvizid);
	
	$mod= $this->module->get_module($modid);
    
	$xml= "<chart caption='".htmlentities($modid['name'])."' xAxisName='Month' yAxisName='$' showValues='0' numberPrefix='$' canvasbgColor='FFFFFF' canvasBorderColor='000000' canvasBorderThickness='2'>";
	$colors = array("FF0000","AA0000","0000FF","0E2964");
	date_default_timezone_set('America/New_York');
    
    $dataids= $this->module->get_modviz_datasets($modid, $modvizid);

	print_r($data_set_results);

	$keys = array_keys($data_set_results); 	
	
	if(count($dataids) > 1) {
	
		$xml.= "<categories>";
		
		foreach($data_set_results[$keys[0]] as $d) {
		
			$xml .="<category label='". $d["label"] . "' />";			
		}
		
		$xml .= "</categories>";
		

		
		foreach($keys as $key) {

			$xml .="<dataset seriesName= '" . $key . "' >";
			
			foreach($data_set_results[$key] as $dt) {
			
				$xml .= "<set value='" . abs($dt["value"]) . "' />";
			}
			
			$xml .="</dataset>";
			
		}
		
		$xml .= "</chart>";
	}
	
	else {
	

		// take a single dataset
		$data_set_results= $data_set_results[$keys[0]];
		
		// iterate through to find month/$ pairs
		foreach($data_set_results as $d) {
		
			$xml .= "<set label= '" .$d["label"]. "' value='" .abs($d["value"]). "'/>";
		}
		
		$xml.= "</chart>";
    }

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
    
    $data['xml'] = $xml;
	$data['modid'] = $modid;
    $data['user'] = $user;
	$data['data_sets'] = $data_sets;
	$data['template'] = $template;
    $data['mod'] = $mod;
	$data['data_set_results'] = $data_set_results;
	$data['modvizid']= $modvizid;
	$data['dataids']= $dataids;

	$data['keys']= $keys;

    $this->load->view('site_nav',$data['user']);	
    $this->user->load_nav($userid);    
    $this->load->view('user_body_start');

    
    $this->load->view('modvizdata',$data);
    $this->load->view('user_body_stop');
    $this->load->view('site_foot');   
  }
}