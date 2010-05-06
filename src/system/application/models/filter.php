<?php
class Filter extends Model {

/************************************************************************
 *                            CONSTRUCTOR METHODS
 ************************************************************************/
  /* PARAMS: void
   * DESCRP: constructor
   */
  function Filter() {
    parent::Model();
  }

  /* PARAMS: $data - hash of data to insert
   * DESCRP: checks if already exists, if not creates it.
   */
  function create($data) {
    // ESCAPE PARAMS
    foreach($data AS $key=>$value) {
      if($data[$key] == '') {
	unset($data[$key]);
      }
      else {
	$data[$key] = $this->db->escape($value);
      }
    }
    $values = array();
    $fields = implode(", ",array_keys($data));
    $values = implode(", ",array_values($data));
    $query = "INSERT INTO public.filter ($fields) VALUES ($values)";
    return $this->db->query($query);
  }

  /* PARAMS: $id - id of filter to delete
   * DESCRP: delete record of filter
   */
  function delete($id) {
    // DELETE FILTER
    $query = "DELETE FROM public.filter WHERE id=$id";
    $this->db->query($query);

    // DELETE MEMOS
    $query = "SELECT memo_id AS id FROM public.filter_memo WHERE filter_id=$id";
    $result = $this->db->query($query);
    $tmp = array();
    foreach( $result->result_array() AS $memo) {
      array_push($tmp, "id=$memo[id]");
    }
    $memo_ids = implode(" OR ", $tmp);
    $query = "DELETE FROM public.memo WHERE $memo_ids";
    $this->db->query($query);

    // DELETE FILTER-MEMO
    $query = "DELETE FROM public.filter_memo WHERE filter_id=$id";
    $this->db->query($query);
  }

/************************************************************************
 *                           ACCESSOR METHODS
 ************************************************************************/
  /* PARAMS: void
   * DESCRP: return hash of all filters info
   */
  function get_filters() {
    $query = "SELECT * FROM public.filter ORDER BY name ASC";
    $result = $this->db->query($query);
    return $result->result_array();
  }

  /* PARAMS: void
   * DESCRP: return hash of the given filters info
   */
  function get_filter($id) {
    $query = "SELECT * FROM public.filter WHERE id=$id ORDER BY name ASC";
    $result = $this->db->query($query);
    return $result->row_array();
  }

  /* PARAMS: $bizid - business id
   * DESCRP: returns hash of memo strings for the given filter
   */
  function get_memos($filter_id) {
    $query = "SELECT t2.memo,t2.id AS id FROM public.filter_memo AS t1, public.memo AS t2 WHERE t1.filter_id = $filter_id AND t2.id = t1.memo_id";
    $result = $this->db->query($query);
    return $result->result_array();
  }

/************************************************************************
 *                               WRITE METHODS
 ************************************************************************/
  /* PARAMS: $id - filter id
   * DESCRP: de-activate filter
   */
  function deactivate($id) {
    $query = "UPDATE public.filter SET active=false WHERE id=$id";
    $this->db->query($query);
  }
  
  /* PARAMS: $data - hash of data to update
   * DESCRP: updates the given id with the given data
   */
  function update($id,$data) {
    $values = array();
    foreach($data AS $key=>$value) {
      if(!empty($value)) {
	$value = $this->db->escape($value);
	array_push($values, "$key=$value");
      }
    }
    $values = implode(", ",$values);
    $query = "UPDATE public.filter SET $values WHERE id=$id";
    $this->db->query($query);
  }
}
