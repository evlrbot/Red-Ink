<?php
class Memo extends Model {

/************************************************************************
 *                            CONSTRUCTOR METHODS
 ************************************************************************/
  /* PARAMS: void
   * DESCRP: constructor
   */
  function Memo() {
    parent::Model();
    $this->load->database();
  }

  /* PARAMS: $memo - memo string
   * DESCRP: add a memo string to the system
   */
  function create($memo) {
    $memo = $this->db->escape($memo);
    $query = "SELECT * FROM public.memo WHERE memo=$memo";
    $result = $this->db->query($query);
    if($result->num_rows()) {
      return false;
    }
    else {
      $query = "INSERT INTO public.memo (memo) VALUES ($memo)";
      $this->db->query($query);
      return true;
    }
  }

  /* PARAMS: $id - memo id
   * DESCRP: remove a memo string from the system
   */
  function delete($id) {
    $id = $this->db->escape($id);
    $query = "DELETE FROM public.memo WHERE id=$id";
    $this->db->query($query);
  }

/************************************************************************
 *                           ACCESSOR METHODS
 ************************************************************************/
/************************************************************************
 *                               WRITE METHODS
 ************************************************************************/
  function update($id,$data) {
    $values = array();
    foreach($data AS $key=>$value) {
      $value = $this->db->escape($value);
      array_push($values, "$key=$value");
    }
    $values = implode(", ",$values);
    $query = "UPDATE public.filter SET $values WHERE id=$id";
    $this->db->query($query);
  }
  
  /* PARAMS: $filter_id - id of filter
   *         $memo_id - id of memo 
   * DESCRP: associate memo with business
   */
  function add($filter_id,$memo_id) {
    $query = "INSERT INTO public.filter_memo (filter_id,memo_id) VALUES ($filter_id,$memo_id)";
    $this->db->query($query);
  }

  /* PARAMS: $filter_id - id of filter
   *         $memo_id - id of memo 
   * DESCRP: disassociate memo from business
   */
  function remove($filter_id,$memo_id) {
    $query = "DELETE FROM public.filter_memo WHERE filter_id=$filter_id AND memo_id=$memo_id";
    $this->db->query($query);
  }
}
