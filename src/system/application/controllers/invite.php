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

class Invite extends Controller {
  
  function Invite() {
    parent::Controller();
  }
  
  function index() {
    $this->load->view('site/head');
    $this->load->view('site/nav');
    $this->load->view('templates/invite');
    $this->load->view('site/foot');
  } 
// VALIDATE USER INPUT

 function validate(){
    	$this->load->library('form_validation');
	$this->load->helper('url');
    	$rules= array(
		array('field'=>'sender', 'label'=>'Name:', 'rules'=>'required'),
		array('field'=>'email','label'=>'Email:', 'rules'=> 'required')
		);
	$this->form_validation->set_rules($rules);
	$this->load->model('invitation');
	$this->invitation->sendMail($_POST['email'],$_POST['message'], $_POST['sender']); 
	redirect('/login/index/', 'refresh');
	
	

}

}
