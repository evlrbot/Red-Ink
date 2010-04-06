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

  /* PARAMS: $dataset_id - id of the dataset to associate
   *         $filter_id - id of the filter to associate
   * DESCRP: associate a transaction filter with a dataset
   */
  function add_filter($dataset_id,$filter_id) {
    $query = "INSERT INTO public.data_filter (dataset_id,filter_id) VALUES ($dataset_id,$filter_id)";
    $this->db->query($query);    
  }

/********************************************************************************
 *                               ACCESSOR METHODS
 ********************************************************************************/
  /* PARAMS: $dataset_id
   * DESCRP: return array of filter data for the given dataset
   */
  function get_filters($dataset_id) {
    $query = "SELECT filter_id AS id FROM data_filter WHERE dataset_id = $dataset_id";
    $result = $this->db->query($query);
    $filters = $result->result_array();
    $memos = array();
    foreach( $filters AS $filter) {
      $query = "SELECT t1.memo FROM public.memo AS t1, public.business_memo AS t2 WHERE t2.bizid = $filter[id] AND t1.id = t2.memoid";
      $result = $this->db->query($query);
      foreach( $result->result_array() AS $m ) {
	array_push($memos,$m['memo']);
      }
    }  
    return($memos);  
  }

  /* PARAMS: $dataid
   * DESCRP: return array of data's fields for given id
   */
  function get_data_sets() {
    $query = "SELECT * FROM public.data";
    $result = $this->db->query($query);
    return $result->result_array();
  }

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