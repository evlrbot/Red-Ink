<?php
class Data extends Model {
/********************************************************************************
 *                                 CONSTRUCTOR
 ********************************************************************************/
  function Data() {
    parent::Model();
    $this->load->database();
  }

/********************************************************************************
 *                                WRITE METHODS
 ********************************************************************************/
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
  /* PARAMS: $dataid
   * DESCRP: return array of data's fields for given id
   */
  function get_data_set($dataid) {
    $query = "SELECT * FROM public.data WHERE id=$dataid LIMIT 1";
    $result = $this->db->query($query);
    return $result->row_array();
  }

  /* PARAMS: 
   * DESCRP: return associative array of data labels and data result arrays
   */
  function get_data_sets_results($datasets,$userid) {
    $data = array();
    foreach($datasets AS $ds) {
      $result = $this->db->query($ds['query'],array($userid));
      $data[$ds['name']] = $result->result_array();
    }
    return $data;
  }
}