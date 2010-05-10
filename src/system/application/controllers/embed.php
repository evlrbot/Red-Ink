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

class Embed extends Controller {
  function Embed() {
    parent::Controller();
  }
  
  function index($module_id) {
    $module = $this->module->get_module($module_id);
    // is the module public
    // if not is the viewer logged in?
    // if so are they a member of the module?
    // if not, prompt them to join. 
    if(($module['public'] == 't') OR ($this->auth->access() && $this->module->has_user($module['id'],$_SESSION['userid']))) {
      $this->load->view('site/head_embed');
      $this->load->view('modules/embed',array('module'=>$module));
      $this->load->view('site/foot');
    }
    else {
      $this->load->view('site/head_embed');
      $this->load->view('modules/unauthorized');
      $this->load->view('site/foot');
    }
  }
}