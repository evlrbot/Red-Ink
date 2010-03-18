<?php
class Me extends Controller {
 
  function Me()
  {
    parent::Controller();
    $this->load->model("auth");
    $this->auth->access();
    $this->load->model("user");
    $this->load->model("api");
    $this->load->model("module");
  }
  
  function index()
  {
    $user_data = $this->user->get_account($_SESSION['userid']);
    $this->load->view('site_nav',$user_data);
    $this->user->load_nav($_SESSION['userid']);
    $this->load->view('user_body_start');
    $this->user->load_modules($_SESSION['userid']);
    $this->load->view('user_body_stop');
    $this->load->view('site_foot');
  }
  

  function account() {
    $user_data = $this->user->get_account($_SESSION['userid']);
    $apis = $this->api->list_apis();
    foreach($apis AS $api) {
      $api_login = $this->user->get_api_login($_SESSION['userid'],$api['id']);
      $user_data[$api['name'].'_username'] = count($api_login) ? $api_login['username'] : '';
      $user_data[$api['name'].'_password'] = count($api_login) ? $api_login['password'] : '';
    }
    $this->load->view('site_nav',$user_data);
    $this->user->load_nav($_SESSION['userid']);
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
		$user_data = $this->user->get_account($_SESSION['userid']);
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
			   'fname'=>$this->input->post('fname'),
			   'lname'=>$this->input->post('lname')
			   );
	$this->user->update($user_data);

	// UPDATE API LOGINS
	$this->load->model("api");
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