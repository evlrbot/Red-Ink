<?php

class Me extends Controller 
{
 
  function Me()
  {
    parent::Controller();
    $this->load->model("auth");
    $this->auth->access();
    $this->load->model("user");
  }

  function index()
  {
    $user_data = $this->user->account_info($_SESSION['userid']);
    $this->load->view('site_nav',$user_data);
    $this->load->view('user_nav');
    $this->load->view('me');
    $this->load->view('site_foot');
  }

  function account() {
    $user_data = $this->user->account_info($_SESSION['userid']);
    $this->load->view('site_nav',$user_data);
    $this->load->view('user_nav');
    $this->load->view('account_info',$user_data);
    $this->load->view('site_foot');
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
	$user_data = $this->user->account_info($_SESSION['userid']);
	$this->load->view('site_nav',$user_data);
	$this->load->view('user_nav');
	$this->load->view('account_info',$user_data);
	$this->load->view('site_foot');
      }
      else {
	// UPDATE USER PROFILE
	$user_data = array(
			   'userid'=>$_SESSION['userid'],
			   'email'=>$this->input->post('email'),
			   'password'=>$this->input->post('password1'),
			   );
	$this->user->account_update($user_data);

	// UPDATE API LOGINS
	$apis = $this->user->list_apis();
	foreach($apis as $api) {
	  $user_data = array(
			     'userid'=>$_SESSION['userid'],
			     'name'=>$api['name'],
			     'apiid'=>$api['id'],
			     'username'=>$this->input->post($api['name'].'_login'),
			     'password'=>$this->input->post($api['name'].'_password')
			     );
	  $this->user->account_api_update($user_data);
	}
	// SEND 'EM BACK
	redirect('me/account');
      }
    }
  }
}