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

class Option extends Model {
  /********************************************************************************
   *                                 CONSTRUCTOR
   ********************************************************************************/
  function Option() {
    parent::Model();
  }
  
  /********************************************************************************
   *                                WRITE METHODS
   ********************************************************************************/
  /* DESCRP: set option values for modules
   * PARAMS: input_type ~ string naming the type of form input element
   *         option_id ~ id of the option to set
   *         option_value ~ value to set the option to
   */
  function set($input_type,$option_id,$option_value) {
    $option_value = $this->db->escape($option_value);
    switch($input_type) {
    case 'select':
      break;
    case 'checkbox':
      $option_value = isset($option_value) ? "true" : "false";
     default:
       break;
     }
     $query = "UPDATE public.module_option SET value=$option_value WHERE id=$option_id";      
     $this->db->query($query);
   }
}
