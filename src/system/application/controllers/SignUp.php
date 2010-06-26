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

class SignUp extends Controller {

  function SignUp(){
    parent::Controller();
  }
    
  function index($invite_id=0){
    $this->load->library('form_validation'); 
    $this->load->library('URI');
    $rules = array(
		   array('field'=>'email','label'=>'E-Mail','rules'=>'required|valid_email'),
		   array('field'=>'password1','label'=>'Password','rules'=>'required|matches[password2]'),
		   array('field'=>'password2','label'=>'Verify Password','rules'=>'required')		       
		   );
    $this->form_validation->set_rules($rules);
    $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

    // FORM NOT SUBMITTED YET
    if($this->form_validation->run() == FALSE){
      $this->load->view('site/head');
      $this->load->view('site/nav');
      $this->load->view('SignUp',array('id'=>$invite_id));   
      $this->load->view('site/foot');
    }   
    // CHECK IF USER ALREADY EXISTS
    elseif($this->user->account_check($this->input->post('email'))) {
      $this->load->view('site/head');
      $this->load->view('site/nav');
      $this->load->view('SignUp',array('id'=>$invite_id, 'msg'=>'<p class="error">That email address is already assigned to a user account.</p>'));
      $this->load->view('site/foot');
    }
    // CREATE NEW USER
    else {
      $this->user->account_create(array('email'=>$this->input->post('email'),'password'=>$this->input->post('password1')));

      // IF THE USER WAS INVITED THROUGH THE INVITATION SYSTEM THEN UDPATE THOSE STATS
      if($invite_id) {
	$user_id =  $this->db->insert_id();
	$query = "UPDATE public.invite WHERE id=$invite_id SET (date_activated, user_id) VALUES (current_timestamp, $user_id)"; 
	$this->db->query($query);
      }

      // RELOAD PAGE WITH SUCCESS MESSAGE
      $this->load->view('site/head');
      $this->load->view('site/nav');
      $this->load->view('SignUp',array('id'=>$invite_id, 'msg'=>'<p class="success">Your account has been created. An e-mail has been sent to the address you provided. Please follow the confirmation instructions, then proceed to the <a href="'.site_url('login').'">login page</a>.</p>'));
      $this->load->view('site/foot');
    }
  }
 
  function Activate($user_id=0) {
    if($user_id) {
      $this->user->activate($user_id);
     redirect(site_url('login/index/1'));
    }
  }
}
