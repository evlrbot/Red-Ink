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

class Consumer extends Controller {
 
  function Consumer() {
    parent::Controller();
    $this->load->model("auth");
    $this->auth->access();
    $this->load->model("user");
  }
  
  function index() {
    $data = $this->user->get_account($_SESSION['userid']);
    $this->load->view('site_nav',$data);
    $this->user->load_nav($_SESSION['userid']);
    $this->load->view('user_body_start');
    $data['users'] = $this->user->get_accounts();
    $this->load->view('list_users',$data);
    $this->load->view('user_body_stop');
    $this->load->view('site_foot');
  }
}