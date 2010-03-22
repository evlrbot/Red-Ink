<?php
class Viz extends Model {

/************************************************************************
 *                            CONSTRUCTOR METHODS
 ************************************************************************/
  /* PARAMS: void
   * DESCRP: constructor
   */
  function Viz() {
    parent::Model();
    $this->load->database();
  }
/************************************************************************
 *                           ACCESSOR METHODS
 ************************************************************************/
  function get_vizs() {
    $query = "SELECT * FROM public.visualization";
    $result = $this->db->query($query);
    return $result->result_array();
  }
  
  function load_vizs($modid, $vizs) {
  
  	foreach($vizs as $viz) {
  	
		$dataids= $this->module->get_modviz_datasets($modid, $viz['modvizid']);
		$viz_datasets= $this->load_viz_datasets($dataids);
		$viz_data= $this->load_viz_data($viz_datasets);
		$xml= $this->format_xml($viz_data, $dataids);
		
		$chart_data= array("viz"=>$viz, "xml"=>$xml, "viz_data"=>$viz_data);
		
		$this->load->view('/modules/bar_chart', $chart_data);
	}
  }
  
  function load_viz_datasets($dataids) {
  
  	$results= array();
  	
  	foreach($dataids as $dataid) {
  		
		$query= "SELECT d.query, md.dataid FROM data AS d, module_data AS md WHERE d.id= md.modid AND md.dataid= ". $dataid['moddataid'];
		$tmp= $this->db->query($query);  
		$results[]= $tmp->result_array();
  	}	
  	
  	return $results;
  }
  
  function load_viz_data($viz_datasets) {
  
		$data = array(); 
	
		foreach($viz_datasets AS $viz_dataset) {
		
			$result = $this->db->query($viz_dataset[0]['query']);
			$data[] = $result->result_array();
		}
	
		return $data;
  }
  
  function format_xml($viz_data, $dataids) {

	$xml= "<chart caption='". " Name of Chart"  ."' xAxisName='Month' yAxisName='$' showValues='0' numberPrefix='$' canvasbgColor='FFFFFF' canvasBorderColor='000000' canvasBorderThickness='2'>";
	$colors = array("FF0000","AA0000","0000FF","0E2964");
	date_default_timezone_set('America/New_York');
	
	$labels= array();
	
	if(count($dataids) > 1) {
	
		$xml.= "<categories>";
			
		foreach($viz_data[0] as $data_pair) {
		
			$labels[]= $data_pair["label"];
			$xml .="<category label='". $data_pair["label"] . "' />";
		}
		
		$xml .= "</categories>";
		
		$i= 1;
		
		foreach($viz_data as $dataset) {
		
			$xml .= "<dataset seriesName= '" . $i . "' >";
		
			$i++;
		
			foreach($dataset as $data_pair) {
				
				$xml .= "<set value='" . abs($data_pair['value']) . "' />";
			}
				
			$xml .= "</dataset>";
		}
		
		$xml .= "</chart>";
	}
	
	else {

		// take a single dataset
		
		if(isset($categories)) {
		
			$single= $categories['name'];
	
			$data_set_results= $data_set_results[$single];
		
			// iterate through to find month/$ pairs
			foreach($data_set_results as $d) {
		
				$xml .= "<set label= '" .$d["label"]. "' value='" .abs($d["value"]). "'/>";
			}
		}
		
		$xml.= "</chart>";
    }
    
    return $xml;
    
  }
  

/************************************************************************
 *                               WRITE METHODS
 ************************************************************************/
  /* PARAMS: $modid - module id
   *         $vizid - visualization id
   * DESCRP: associate a visualization with a module
   */
  function add($modid,$vizid) {
    if(is_numeric($modid) && is_numeric($vizid) ) {
      $query = "INSERT INTO module_visualization (modid,vizid) VALUES ($modid,$vizid)";
      $this->db->query($query);
    }
  }
  
  /* PARAMS: $modid - module id
   *         $vizid - visualization id
   * DESCRP: disassociate a visualization from a module
   */
  function remove($modvizid) {
    if(is_numeric($modvizid)) {
      $query = "DELETE FROM module_visualization WHERE id=$modvizid";
      $this->db->query($query);
    }
  }

  function edit_mod($modid,$vizid) {
    
  }
}
