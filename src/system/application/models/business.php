<?php
class Business extends Model {

/************************************************************************
 *                            CONSTRUCTOR METHODS
 ************************************************************************/
  /* PARAMS: void
   * DESCRP: constructor
   */
  function Business() {
    parent::Model();
    $this->load->database();
  }

  /* PARAMS: $data - hash of data to insert
   * DESCRP: checks if already exists, if not creates it.
   */
  function create($data) {
    // CHECK IF ALREADY EXISTS
    $query = "SELECT * FROM public.business WHERE address1='$data[address1]' AND address2='$data[address2]' AND name='$data[name]' AND city='$data[city]' AND state='$data[state]' AND zip='$data[zip]' LIMIT 1";
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

/************************************************************************
 *                           ACCESSOR METHODS
 ************************************************************************/
  /* PARAMS: void
   * DESCRP: return hash of all orgs info
   */
  function get_bizs() {
    $query = "SELECT * FROM public.business ORDER BY name ASC";
    $result = $this->db->query($query);
    return $result->result_array();
  }

/************************************************************************
 *                               WRITE METHODS
 ************************************************************************/
}
