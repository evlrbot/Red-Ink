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

class Login extends Controller {
  
  function Login() {
    parent::Controller();
  }
  
  function index() {
    $this->load->view('site/head');
    $this->load->view('site/nav');
    $this->load->view('templates/login');
    $this->load->view('site/foot');
  }
  
  function auth() {
    // VALIDATE FORM
    if($_SERVER['REQUEST_METHOD'] == "POST") {
      $this->load->library('form_validation');   
      $rules = array(
		     array('field'=>'username','label'=>'Username','rules'=>'required|valid_email'),
		     array('field'=>'password','label'=>'Password','rules'=>'required')
		     );
      $this->form_validation->set_rules($rules);
      $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
      // FORM DOES NOT VALIDATE...RE-PROMPT
      if($this->form_validation->run() == FALSE) {
	$this->load->view('templates/login');   
      }
      else {
	// FORM VALIDATES...CHECK IF USER EXISTS AND ACCOUNT IS VERIFIED
	if($uid = $this->auth->authorize()) {
	  //USER EXISTS AND ACCOUNT IS VERIFIED...START SESSION
	  $this->auth->start_session($uid);
	  redirect('me');
	}
	else {
	  //USER DOES NOT EXIST... DISPLAY ERROR 
	  $data = array('msg'=>'<p><span class="error">The username or password for that user was incorrect.</span></p>');
	  $this->load->view('site/head');
	  $this->load->view('site/nav');
	  $this->load->view('templates/login',$data);
	  $this->load->view('site/foot');
	}
      }
    }
    else {
      redirect('login');
    } 
  }
}