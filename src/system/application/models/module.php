<?php
class Module extends Model {
/********************************************************************************
 *                                 CONSTRUCTOR
 ********************************************************************************/
  function Module() {
    parent::Model();
    $this->load->database();
  }

/********************************************************************************
 *                                WRITE METHODS
 ********************************************************************************/
  /* PARAMS: $data
   * DESCRP: create a new module with the provided meta data
   */
  function create_module($userid,$data) {
    // ESCAPE INSERTION STRINGS, 
    // NEED TO ADD ADDITIONAL CHECKS FOR MALICIOUS CODE INSERTIONS
    for($i=0;$i<count($data);$i++) {
      $data[$i] = $this->db->escape($data[$i]);
    }
    // ADD MODULE
    $query = "INSERT INTO public.module (name,description) VALUES (".implode(",",$data).")";
    $this->db->query($query);
    $modid = $this->db->insert_id();
    // ADD OWNER
    $query = "INSERT INTO public.owner (userid,modid) VALUES ($userid,$modid)";
    $this->db->query($query);
  }

  /* PARAMS: $modid - module to update
   *         $data - array of data to update
   * DESCRP: update the module with the data
   */
  function update_module($modid,$data) {
    // NEED TO ADD ADDITIONAL CHECKS FOR MALICIOUS CODE INSERTIONS
    $values = array();
    foreach($data AS $key=>$value) {
      array_push($values,"$key=".$this->db->escape($data[$key]));
    }
    $values = implode(", ",$values);
    $query = "UPDATE public.module SET $values WHERE id=$modid";
    $this->db->query($query);
  }

  /* PARAMS: $modid - module to delete
   * DESCRP: remove referrences to this module
   *         in the appropriate tabels
   */
  function delete_module($modid) {
    $query = "DELETE FROM public.module WHERE id=$modid";
    $this->db->query($query);
    $query = "DELETE FROM public.owner WHERE modid=$modid";
    $this->db->query($query);
  }

  /* PARAMS: $modid - module to deactivate
   * DESCRP: Flag module as deactivated.
   */
  function deactivate_module($modid) {
    $query = "UPDATE public.module SET active=0 WHERE id=$modid";
    $this->db->query($query);
  }

  /* PARAMS: $modid - module to activate
   * DESCRP: Flag module as active.
   */
  function activate_module($modid) {
    $query = "UPDATE public.module SET active=1 WHERE id=$modid";
    $this->db->query($query);
  }

  /* PARAMS: $userid - user to lookup
   *         $modid - module to lookup
   * DESCRP: add module to user account
   */
  function add_user($userid,$modid) {
    $query = "INSERT INTO public.user_module (userid,modid,viewid) VALUES ($userid,$modid,13)";
    $this->db->query($query);
  }

  /* PARAMS: $userid - user to lookup
   *         $modid - module to lookup
   * DESCRP: rm user user from module
   */
  function remove_user($userid,$modid) {
    $query = "DELETE FROM public.user_module WHERE userid='$userid' AND modid='$modid'";
    $this->db->query($query);
  }

  /* PARAMS: $dataid - dataset id
   *         $name - dataset name
   *         $query - dataset query
   * DESCRP: update the dataset with new data
   */
  function update_data_set($dataid,$name,$query) {
    $name = $this->db->escape($name);
    $query = $this->db->escape($query);
    $q = "UPDATE public.data SET name=$name, query=$query WHERE id=$dataid";
    $this->db->query($q);
  }

  
/********************************************************************************
 *                               ACCESSOR METHODS
 ********************************************************************************/
  /* PARAMS: $modid - id of the module to load
   *         $viewid - id of the view to load
   *         $userid - id of the user loading the module/view
   * DESCRP: Loads the appropriate module/view/data given the above params
   */
  function load($modid,$viewid,$userid) {
  
    $data['mod'] = $this->get_module($modid);
    $data['data'] = $this->get_data_sets_results($this->get_data_sets($modid),$userid);  
    if(count($data['data']) > 0) {
    	$data['viz']= $this->get_visualizations($modid);
    	
    	foreach($data['viz'] as $viz) {
    	
			$modvizid= $viz['modvizid'];
			$this->viz->load_viz($modid, $modvizid);
    	}
    	
		//$this->load->view("modules/$template",$data);
		//$this->load->view("modules/bar_chart",$data);
    }
  }

 /* PARAMS: $modid
   * DESCRP: return associative array of data ids, labels and query strings
   */
  function get_data_sets($modid) {
    $query = "SELECT t2.name, t2.id AS dataid, t2.query FROM public.module_data AS t1, public.data AS t2 WHERE modid=$modid AND t1.dataid = t2.id ORDER BY t1.order ASC";
    $result = $this->db->query($query);    
    return $result->result_array();
  }

  /* PARAMS: $modid
   * DESCRP: return associative array of data labels and data result arrays
   */
  function get_data_sets_results($datasets,$userid) {
    $data = array();
    foreach($datasets AS $ds) {
      if($ds['query']!= '0') {
        $result = $this->db->query($ds['query'],array($userid));
        $data[$ds['name']] = $result->result_array();
      }
      else {
        $data[$ds['name']] = array();
      }
    }
    return $data;
  }

  /* PARAMS: $viewid
   * DESCRP: For a given view returns the view's associate template file path
   */
  function get_template($modviewid) {
    $query = "SELECT v.template, v.multidata, v.stacked FROM visualization AS v, module_visualization AS mv WHERE mv.id=$modviewid AND mv.vizid= v.id LIMIT 1";
    $result = $this->db->query($query);
    $tmp = $result->row_array();
    return $tmp;
  }

  /* PARAMS: void
   * DESCRP: return list of all modules except sample module id 1
   */
  function get_modules() {
    $query = "SELECT * FROM public.module WHERE id<> 1";
    $result = $this->db->query($query);
    return $result->result_array();
  }

  /* PARAMS: $modid
   * DESCRP: return info on the given module
   */
  function get_module($modid) {
    $query = "SELECT * FROM public.module WHERE id=$modid LIMIT 1";
    $result = $this->db->query($query);
    return $result->row_array();
  }
 
  /* PARAMS: $modid - module id
   * DESCRP: list views associated with this module. If vizid was passed 
   *         select a single viz else select all vizs.
   */
  function get_visualizations($modid, $vizid = 0) {  
    if($vizid) {
      $query = "SELECT t1.name, t1.template, t1.multidata, t1.stacked, t2.id AS modvizid, t2.viz_name, t2.stacked AS viz_stacked FROM public.visualization AS t1, public.module_visualization AS t2 WHERE t1.id = t2.vizid AND t2.modid = $modid AND t2.id=$vizid";    	
      $result = $this->db->query($query);
      return $result->row_array();      
    }
    else {
      $query = "SELECT t1.name, t1.template, t1.multidata, t1.stacked, t2.id AS modvizid, t2.viz_name, t2.stacked AS viz_stacked FROM public.visualization AS t1, public.module_visualization AS t2 WHERE t1.id = t2.vizid AND t2.modid = $modid";
      $result = $this->db->query($query);
      return $result->result_array();    	
    }
  }
  
  function add_mod_dataid($modid,$modvizid, $moddataid) {
    $query = "INSERT INTO public.mod_viz_data (modid,modvizid,moddataid) VALUES ($modid,$modvizid,$moddataid)";
    $this->db->query($query);
  }  
  
  function get_modviz_datasets($modid, $modvizid) {
  	$query= "SELECT mvd.moddataid, mvd.moddataid_color, d.name FROM public.data AS d, public.mod_viz_data as mvd WHERE mvd.modid=$modid AND mvd.moddataid= d.id AND mvd.modvizid= $modvizid;";
    $result= $this->db->query($query);
	 return $result->result_array();
  }
  
 
  
  
  /* PARAMS: $type - single, multi, combo
   * DESCRP: generates the xml to be loaded in charts.  
   */  
  function write_xml($type, $data, $mod) {

	switch($type) {
	
		case 'single':
			
			$xml= "<chart caption='".htmlentities($mod['name'])."' xAxisName='Month' yAxisName='$' showValues='0' numberPrefix='$' canvasbgColor='FFFFFF' canvasBorderColor='000000' canvasBorderThickness='2'>";
			$colors = array("FF0000","AA0000","0000FF","0E2964");
			date_default_timezone_set('America/New_York');
			$keys = array_keys($data);
			
			foreach($data[$keys[0]] as $d) {
			
				$xml .= "<set label= '0' value='" .abs($d['value']). "'/>";
			}
			
			
			$xml.= "</chart>";
	
			break;
			
		case 'multi':
			
			$xml= "<chart caption='".htmlentities($mod['name'])."' xAxisName='Month' yAxisName='$' showValues='0' numberPrefix='$' canvasbgColor='FFFFFF' canvasBorderColor='000000' canvasBorderThickness='2'>";
			$colors = array("FF0000","AA0000","0000FF","0E2964");
			date_default_timezone_set('America/New_York');
			$keys = array_keys($data);
			$xml.= "<categories>";
			
			foreach($data[$keys[0]] AS $d) {
			  $d['label'] = date_format(date_create($d['label']), "M y");
			  $xml.= "<category label='$d[label]'/>";
			}
			
			$xml.="</categories>";
			$i = 0;
			
			foreach($keys AS $index) {
			  $xml.= "<dataset seriesName='$index' color='$colors[$i]'>";
			  foreach($data[$index] AS $d) {
				$xml.= "<set value='".abs($d['value'])."'/>";
			  }
			  $xml.="</dataset>";
			  $i++;
			}
			
			foreach($data[$keys[0]] as $d) {
			
				$xml .= "<set label= '0' value='" .abs($d['value']). "'/>";
			}
			
			
			$xml.= "</chart>";
			
			
			break;
		
		case 'combo':
		
			break;
	}
	
	return $xml;
	
  }
}