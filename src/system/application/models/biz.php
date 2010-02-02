<?php
class Biz extends Model {

/************************************************************************
 *                            CONSTRUCTOR METHODS
 ************************************************************************/
  /* PARAMS: void
   * DESCRP: constructor
   */
  function Biz() {
    parent::Model();
    $this->load->database();
  }

  /* PARAMS: $data - hash of data to insert
   * DESCRP: checks if already exists, if not creates it.
   */
  function create($data) {
    // CHECK IF ALREADY EXISTS
    $query = "SELECT * FROM public.business WHERE address1='$data[address1]' AND address2='$data[address2]' AND name='$data[name]' AND city='$data[city]' AND state='$data[state]' AND zip1='$data[zip1]' AND zip2='$data[zip2]' LIMIT 1";
    $result = $this->db->query($query);
    // IF NOT EXISTS THEN ADD
    if($result->num_rows() == 0) {
      $values = array();
      foreach($data AS $key=>$value) {
	$data[$key] = $this->db->escape($value);
      }
      $fields = implode(", ",array_keys($data));
      $values = implode(", ",array_values($data));
      $query = "INSERT INTO public.business ($fields) VALUES ($values)";
      $result = $this->db->query($query);
      return true;
    }
    else {
      return false;
    }
  }

  function delete($id) {
    $query = "DELETE FROM public.business WHERE id=$id";
    $this->db->query($query);
  }

/************************************************************************
 *                           ACCESSOR METHODS
 ************************************************************************/
  /* PARAMS: void
   * DESCRP: return hash of all businesses' info
   */
  function get_bizs() {
    $query = "SELECT * FROM public.business WHERE active=true ORDER BY name ASC";
    $result = $this->db->query($query);
    return $result->result_array();
  }

  /* PARAMS: void
   * DESCRP: return hash of the given business' info
   */
  function get_biz($id) {
    $query = "SELECT * FROM public.business WHERE id=$id AND active=true ORDER BY name ASC";
    $result = $this->db->query($query);
    return $result->row_array();
  }

  /* PARAMS: $bizid - business id
   * DESCRP: returns hash of memo strings for the given business
   */
  function get_memos($bizid) {
    $query = "SELECT t2.memo,t2.id FROM public.business_memo AS t1, public.memo AS t2 WHERE t1.bizid = $bizid";
    $result = $this->db->query($query);
    return $result->result_array();
  }

/************************************************************************
 *                               WRITE METHODS
 ************************************************************************/
  /* PARAMS: $id - business id
   * DESCRP: flag the business as de-activated
   */
  function deactivate($id) {
    $query = "UPDATE public.business SET active=false WHERE id=$id";
    $this->db->query($query);
  }

  /* PARAMS: $data - hash of data to update
   * DESCRP: updates the given id with the given data
   */
  function update($id,$data) {
    $values = array();
    foreach($data AS $key=>$value) {
      $value = $this->db->escape($value);
      array_push($values, "$key=$value");
    }
    $values = implode(", ",$values);
    $query = "UPDATE public.business SET $values WHERE id=$id";
    $this->db->query($query);
  }
}
