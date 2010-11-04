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

class Me extends Controller {
 
  function Me()
  {
    parent::Controller();
    $this->auth->access() ? "" : redirect(site_url('login'));
  }
  
  function index() {
    $modules = $this->user->get_modules($_SESSION['userid']);
    $this->load->view('site/head',array("data"=>$modules));
    $this->load->view('site/nav',$this->user->get_account($_SESSION['userid']));
    $this->load->view('site/body_start');
    if( $modules ) {    	
      foreach($modules as $mod) {
	$this->module->load($mod['modid']);
      }
    }
    else {
      $this->load->view('modules/welcome_message');
    }
    $this->load->view('site/body_stop');
    $this->load->view('site/foot');
  } 

  function account() {
    $user_data = $this->user->get_account($_SESSION['userid']);
    $apis = $this->api->list_apis();
    foreach($apis AS $api) {
      $api_login = $this->user->get_api_login($_SESSION['userid'],$api['id']);
      $user_data[$api['name'].'_username'] = count($api_login) ? $api_login['username'] : '';
      $user_data[$api['name'].'_password'] = count($api_login) ? $api_login['password'] : '';
    }
    $this->load->view('site/head');
    $this->load->view('site/nav',$this->user->get_account($_SESSION['userid']));
    $this->load->view('site/body_start');
    $this->load->view('templates/account_info',$user_data);
    $this->load->view('site/body_stop');
    $this->load->view('site/foot');
  }

  function account_update() {
    if($_SERVER['REQUEST_METHOD']=="POST") {
      // VALIDATE SUBMITTED DATA
      $this->load->library('form_validation');   
      $rules = array(
		     array('field'=>'email','label'=>'E-Mail','rules'=>'required|valid_email'),
		     array('field'=>'password1','label'=>'Password','rules'=>'matches[password2]')
		     );
      $this->form_validation->set_rules($rules);
      $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
      if($this->form_validation->run() == FALSE) {
	$user_data = $this->user->get_account($_SESSION['userid']);
	$apis = $this->api->list_apis();
	foreach($apis AS $api) {
	  $api_login = $this->user->get_api_login($_SESSION['userid'],$api['id']);
	  $user_data[$api['name'].'_username'] = count($api_login) ? $api_login['username'] : '';
	  $user_data[$api['name'].'_password'] = count($api_login) ? $api_login['password'] : '';
	}
	$this->load->view('site/head');
	$this->load->view('site/nav',$this->user->get_account($_SESSION['userid']));
	$this->load->view('site/body_start');
	$this->load->view('templates/account_info',$user_data);
	$this->load->view('site/body_stop');
	$this->load->view('site/foot');
      }
      else {
	// UPDATE USER PROFILE
	$user_data = array(
			   'userid'=>$_SESSION['userid'],
			   'email'=>$this->input->post('email'),
			   'password'=>$this->input->post('password1'),
			   'fname'=>$this->input->post('fname'),
			   'lname'=>$this->input->post('lname')
			   );
	$this->user->update($user_data);

	// UPDATE API LOGINS
	$apis = $this->api->list_apis();
	foreach($apis as $api) {
	  $user_data = array(
			     'userid'=>$_SESSION['userid'],
			     'name'=>$api['name'],
			     'apiid'=>$api['id'],
			     'username'=>$this->input->post($api['name'].'_login'),
			     'password'=>$this->input->post($api['name'].'_password')
			     );
	  $this->user->update_api_login($user_data);
	}
	// SEND 'EM BACK
	redirect('me/account');
      }
    }
  }  
}