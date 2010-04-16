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
    $this->load->model('data');
  }
/************************************************************************
 *                           ACCESSOR METHODS
 ************************************************************************/
  /* PARAMS: void
   * DESCRP: return result set containing all data from the visualization table
   */
  function get_vizs() {
    $query = "SELECT * FROM public.visualization";
    $result = $this->db->query($query);
    return $result->result_array();
  }

  /* PARAMS: $modvizid - module visualization id
   * DESCRP: list datasets associated with this visualization
   */ 
  function get_datasets($modvizid) {
    $query = "SELECT mvd.moddataid, mvd.moddataid_color, d.name FROM public.data AS d, public.mod_viz_data as mvd WHERE mvd.moddataid = d.id AND mvd.modvizid= $modvizid;";
    $result = $this->db->query($query);
    return $result->result_array();
  }

  /* PARAMS: void
   * DESCRP: constructs a query using the filters associated with a vis and the vis' 
   *         settings for period and frequency of aggregation.
   * RETURN: array(array()) of results data keyed by dataset title and user or module level aggregation
   */ 
  function get_dataset_results($modvizid,$userid) {
    // GET VISUALIZATION'S DATASETS
    $datasets = $this->get_datasets($modvizid);   
    // GET MEMO STRINGS FROM DATASETS
    $results = array();
    foreach($datasets AS $ds) {                   
      $memos = $this->data->get_memos($ds['moddataid']);
      // CONVERT MEMOS STRINGS INTO SQL STATEMENT
      for($i=0;$i<count($memos);$i++) {  
	$memos[$i] = "memo ILIKE '%$memos[$i]%' OR merchant ILIKE '%$memos[$i]%'";
      }
      $memos = implode(' OR ',$memos);
      $frequency = 'month';
      $query = "SELECT date_part('epoch', date_trunc('month',created))*1000 AS label, abs(round(sum(amount)/100.0,2)) AS value FROM public.transaction";
      $query .= " WHERE $memos ";
      $query .= "GROUP BY date_part('epoch', date_trunc('month',created))*1000 ORDER BY label ASC";
      $result = $this->db->query($query);
      $results[$ds['name']] = $result->result_array();
    }    
    return $results;
  }

  /* PARAMS: $data - serialized data from the query
   * DESCRP: returns json object of serialized data
   */
  function format_json($data, $data_sets) {  
    $tmp = array();
    foreach($data AS $key=>$value) {
	  foreach($data_sets as $ds) {
	    if($key== $ds['name']) {
	      $color= $ds['color'];
	      if($color== 'random') {
		    $colors= array('#0000FF', '#FF0000', '#F7FF00', '#00FF00', '#FF00DD', '#FF8F00');
		    shuffle($colors);
		    $color= $colors[0];
	      }
	    }
	  }
      $tmp2 = array();
      $j=0;
      foreach($value AS $v) {
	$tmp2[$j] = "[$v[label],$v[value]]";
	$j++;
      }
      array_push($tmp,"{label:'$key',color:'$color',data:[".implode(',',$tmp2)."]}");
    }
    return $json = "[".implode(',',$tmp)."]";    
  }

  /* PARAMS:
   * DESCRP:
   */
  function load_sample_vizs($modid) {
    $vizs= $this->viz->get_vizs();
    foreach($vizs as $viz) {
      $data= array("viz"=>$viz, "modid"=>$modid);
      $this->load->view('/list_visualization', $data);
    }
  }

  /* PARAMS: $modid - id of the module in question
   *         $vizs - visualizations available to this module
   * DESCRP: 
   */  
  function load_vizs($modid, $vizs) {
    foreach($vizs as $viz) {
	  $modvizid= $viz['modvizid'];
      $data_set_results = $this->get_dataset_results($viz['modvizid'],$_SESSION['userid']);
      $data_sets= $this->module->get_data_sets($modid);     

	  for($i=0; $i<count($data_sets); $i++) {
		foreach($this->viz->get_datasets($modvizid) AS $ds) {
	  if($data_sets[$i]["dataid"] == $ds["moddataid"]) {
		$data_sets[$i]["color"]= $ds['moddataid_color'];
	  }
		}
	  }      

      $json = $this->viz->format_json($data_set_results, $data_sets);
      $data = array("json"=>$json,'viz'=>$viz);
      $this->load->view('/modules/bar_chart', $data);
    }
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
}
