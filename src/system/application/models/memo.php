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

class Memo extends Model {

/************************************************************************
 *                            CONSTRUCTOR METHODS
 ************************************************************************/
  /* PARAMS: void
   * DESCRP: constructor
   */
  function Memo() {
    parent::Model();
  }

  /* PARAMS: $memo - memo string
   * DESCRP: add a memo string to the system
   */
  function create($memo) {
    $memo = $this->db->escape($memo);
    $query = "INSERT INTO public.memo (memo) VALUES ($memo)";
    return $this->db->query($query);
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
