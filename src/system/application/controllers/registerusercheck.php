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

class RegisterUserCheck extends Controller {

  function RegisterUserCheck(){
    parent::Controller();
  }
    
  function index(){
    $this->load->library('form_validation');   
    $rules = array(
		   array('field'=>'email','label'=>'E-Mail','rules'=>'required|valid_email'),
		   array('field'=>'password1','label'=>'Password','rules'=>'required|matches[password2]'),
		   array('field'=>'password2','label'=>'Verify Password','rules'=>'required')		       
		   );
    $this->form_validation->set_rules($rules);
    $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
    if($this->form_validation->run() == FALSE){
      $this->load->view('site/head');
      $this->load->view('site/nav');
      $this->load->view('register_user_check');   
      $this->load->view('site/foot');
    }   
    elseif($this->user->account_check(array('email'=>$this->input->post('email'),'password'=>$this->input->post('password1')))) {
      $this->load->view('site/head');
      $this->load->view('site/nav');
      $this->load->view('register_user_check',array('msg'=>'<p class="error">That email address is already assigned to a user account.</p>'));
      $this->load->view('site/foot');
    }
    else { 
      

    }
  }
}