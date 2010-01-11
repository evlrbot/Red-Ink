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
	// UPDATE THE USER'S PROFILE DATA
	$user_data = array(
			   'userid'=>$_SESSION['userid'],
			   'email'=>$this->input->post('email'),
			   'password'=>$this->input->post('password1'),
			   );
	$this->user->account_update($user_data);

	// UPDATE THE USER'S API LOGINS
	$user_data = array(
			   'expensify_username'=>$this->input->post('expensify_username'),
			   'expensify_password'=>$this->input->post('expensify_password'),
			   'wesabe_username'=>$this->input->post('wesabe_username'),
			   'wesabe_password'=>$this->input->post('wesabe_password')
			   );
	//$this->user->account_api_update($user_data);

	// SEND 'EM BACK
	redirect('me/account');
      }
    }
  }
}