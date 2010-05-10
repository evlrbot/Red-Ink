<?php
/*
Red Ink - Consumer Analytics for People and Communities
Copyright (C) 2010  Ryan O'Toole

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU Affero General Public License as
published by the Free Software Foundation, either version 3 of the
License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

class Data extends Model {
/********************************************************************************
 *                                 CONSTRUCTOR
 ********************************************************************************/
  function Data() {
    parent::Model();
    $this->load->database();
    $this->load->model('biz');
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

  /* PARAMS: $dataset_id - id of the dataset to associate
   *         $filter_id - id of the filter to associate
   * DESCRP: associate a transaction filter with a dataset
   */
  function remove_filter($dataset_id,$filter_id) {
    $query = "DELETE FROM public.data_filter WHERE dataset_id = $dataset_id AND filter_id = $filter_id";
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
    $ids = $result->result_array();
    $filters = array();
    foreach( $ids AS $id) {
      array_push($filters,$this->biz->get_biz($id['id']));
    }  
    return($filters);  
  }

  /* PARAMS: $dataset_id
   * DESCRP: return query based on the dataset's filters
   */
  function get_memos($dataset_id) {
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