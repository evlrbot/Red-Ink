<?php
class Api extends Model {

  function Api() {
    parent::Model();
    $this->load->database();
  }

  function list_apis() {
    $result = $this->db->query("SELECT * FROM public.api");
    return $result->result_array();
  }
}
