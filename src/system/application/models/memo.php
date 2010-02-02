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
    $query = "INSERT INTO public.memo (memo) VALUES ($memo)";
    $this->db->query($query);
  }

  /* PARAMS: $id - memo id
   * DESCRP: remove a memo string from the system
   */
  function delete($id) {
    $query = "DELETE FROM public.business WHERE id=$id";
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
    $query = "UPDATE public.business SET $values WHERE id=$id";
    $this->db->query($query);
  }
  
  /* PARAMS: $bizid - id of business
   *         $memoid - id of memo 
   * DESCRP: associate memo with business
   */
  function add($bizid,$memoid) {
    $query = "INSERT INTO public.business_memo (bizid,memoid) VALUES ($bizid,$memoid)";
    $this->db->query($query);
  }

  /* PARAMS: $bizid - id of business
   *         $memoid - id of memo 
   * DESCRP: disassociate memo from business
   */
  function remove($bizid,$memoid) {
    $query = "DELETE FROM public.business_memo WHERE bizid=$bizid AND memoid=$memoid";
    $this->db->query($query);
  }
}
