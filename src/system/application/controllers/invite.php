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

class Invite extends Controller{
  
  function Invite() {
    parent::Controller();
  }
  
  function index($modid) {
    $mod=$this->module->get_module($modid);
    $data['mod_info']=array('name'=>$mod['name'],'description'=>$mod['description'],'pre_message'=>'Join Red Ink and use the '.$mod['name'].' module; '.$mod['description']);
    $this->load->view('templates/invite',$data);
  } 

 function validate() {
	$profile=$this->user->get_profile($_SESSION['userid']);
    	$this->load->library('form_validation');
	$this->load->helper('url');
    	$rules= array(
		array('field'=>'sender', 'label'=>'Name', 'rules'=>'required'),
		array('field'=>'email','label'=>'Email', 'rules'=> 'required')
		);
	$this->form_validation->set_rules($rules);
	// FORM DOES NOT VALIDATE, RELOAD VIEW
	if ($this->form_validation->run()==FALSE){
   	  $this->load->view('templates/invite');
 	 }
	// FORM VALIDATION SUCCESSFUL
	else {

	$this->load->model('invitation');
	$this->invitation->sendMail($_POST['email'],$_POST['message'], $_POST['sender'],$_POST['pre_message'],$profile['email']);
	
	}	
 }

/* function get_mod($mod_id) {
   $modules=$this->module->get_modules();
   foreach ($modules as $data) {
     if ($data[id]==$mod_id) 
         return $data;
   }
 }
*/

}

