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
  
  function load_vizs($mod, $vizs) {
  
  	$modid= $mod['modid'];
  	$mod_info= $this->module->get_module($modid);
  
	foreach($vizs as $viz) {
	
		$dataids= $this->module->get_modviz_datasets($modid, $viz['modvizid']);
		
		$viz_datasets= $this->load_viz_datasets($dataids);
		$viz_data= $this->load_viz_data($viz_datasets);
		
		$chart_name= $viz['viz_name'];
		
		$xml= $this->format_xml($viz_data, $dataids, $chart_name);
		
		$chart_data= array("viz"=>$viz, "xml"=>$xml, "viz_data"=>$viz_data);
		
		$this->load->view('/modules/bar_chart', $chart_data);
	}
  }
  
  function load_sample_vizs($modid) {
  
  	$vizs= $this->viz->get_vizs();

  
	foreach($vizs as $viz) {
		
		$data= array("viz"=>$viz, "modid"=>$modid);
		$this->load->view('/list_visualization', $data);
	}
  }
  
  function load_viz_datasets($dataids) {
  
  	$results= array();
  	
  	foreach($dataids as $dataid) {
  		
  		$name= $dataid['name'];
		$query= "SELECT d.query FROM data AS d WHERE d.id= ". $dataid['moddataid'];
		$tmp= $this->db->query($query);
		$results[$name]= $tmp->row_array();
	}	
  	
  	return $results;
  }
  
  function load_viz_data($viz_datasets) {
  
		$data = array(); 
		
		foreach($viz_datasets AS $key=>$viz_dataset) {

			// pass the dataset name on as the array key for data
			$name= array_keys($viz_dataset);
			// only one array key per dataset
			$name= $name[0];
			
			$result = $this->db->query($viz_dataset['query']);
			$data[$key] = $result->result_array();
		}
		
		return $data;
  }
  
  function format_xml($viz_data, $data_ids, $chart_name) {

	  $xml= "<chart caption='". $chart_name ."' bgColor= 'FFFFFF' plotGradientColor='' showBorder= '0' showValues='0' numberPrefix='$' canvasbgColor='000000' canvasBorderColor='000000' canvasBorderThickness='2' showPlotBorder='0' useRoundEdges='1' canvasBorderThickness= '0' chartTopMargin= '0' paletteColors= 'FF0000, 0000FF, AA0000, 0E2964'>";
	  
	  // figure out a place for these
	  
	  $colors = array("FF0000","AA0000","0000FF","0E2964");
	  //date_default_timezone_set('America/New_York');
	  
	  $xml.= "<styles>
			    <definition>
            		<style name='Title' type='font' face='Arial' size='15' color='000000' bold='1'/>
            		<style name='Labels' type='font' face='Arial' size='15' color='000000' bold='1'/>
					<style name='Values' type='font' face='Arial' size='13' color='000000' bold='0'/>
					<style name='YValues' type='font' face='Arial' size='24' color='000000' bold='1'/>
					<style name='Bevel' type='bevel' distance='0'/>
		            <style name='Shadow' type='shadow' angle='45' distance='0'/>
      			</definition>
      			<application>
            		<apply toObject='Caption' styles='Title' />
            		<apply toObject='Datalabels' styles='Values' />
            		<apply toObject='Datavalues' styles='Values' />         
            		<apply toObject='Xaxisname' styles='Labels' />
            		<apply toObject='Yaxisname' styles='YValues' />
            		<apply toObject='Yaxisvalues' styles='Values' />            		
            		<apply toObject='DataPlot' styles='Bevel, Shadow' />
				</application>    
			  </styles>";
	  
	  
	  $labels= array();
	  
	  if(count($data_ids) > 1) {
	  
		  $xml.= "<categories>";
		  
		  //  gets keys to iterate thru array - probably a cleaner way of doing this
		
		$keys= array_keys($viz_data);
			
		  foreach($viz_data[$keys[0]] as $data_pair) {
		  
			  $label= date('M', strtotime($data_pair["label"]));
			  $labels[]= $label;
			  $xml .="<category label='". $label . "' />";
		  }
		  
		  $xml .= "</categories>";
		  
		  foreach($viz_data as $key=>$dataset) {
		  
			  $xml .= "<dataset seriesName= '$key' >";
		  
		  	// counter for multiseries colors  
		  	
			  $i= 0;
			  
		  
			  foreach($dataset as $data_pair) {
				  
				  $xml .= "<set value='" . abs($data_pair['value']) . "'/>";
				  
				  // cycle thru colors
				  
				  $i > 2 ? $i= 0 : $i++;
			  }
				  
			  $xml .= "</dataset>";
		  }
		  
		  $xml .= "</chart>";
	  }
	  
	  else {
		  
		  if($key= array_keys($viz_data)) {
		  	  
		  	  $key= $key[0];
		  	  
			  foreach($viz_data[$key] as $data_pair) {
			  
	  			  $label= date('M', strtotime($data_pair["label"]));
				  $xml .= "<set label= '" .$label. "' value='" .abs($data_pair["value"]). "' color='FF0000'/>";
			  }
			  
			  $xml.= "</chart>";
		  }
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
