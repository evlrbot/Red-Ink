<?php
class User extends Model {

  function User() {
    parent::Model();
    $this->load->database();
  }

  function account_info() {
    $query = "SELECT * FROM public.user WHERE id='$_SESSION[userid]' LIMIT 1";
    $result = $this->db->query($query);
    return $result->row_array();
  }
}
