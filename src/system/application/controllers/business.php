<?php
class Business extends Controller {
 
  function Business()
  {
    parent::Controller();
    $this->load->model("auth");
    $this->auth->access();
    $this->load->model("user");
    $this->load->model("biz");
  }

  function index()
  {
    $data = $this->user->get_account($_SESSION['userid']);
    $this->load->view('site_nav',$data);
    $this->user->load_nav($_SESSION['userid']);
    $this->load->view('user_body_start');
    $data['bizs'] = $this->biz->get_bizs();
    $this->load->view('list_orgs',$data);
    $this->load->view('user_body_stop');
    $this->load->view('site_foot');
  }

  function account() {
    $user_data = $this->user->get_account($_SESSION['userid']);
    $apis = $this->api->list_apis();
    foreach($apis AS $api) {
      $api_login = $this->user->get_api_login($_SESSION['userid'],$api['id']);
      $user_data[$api['name'].'_username'] = $api_login['username'];
      $user_data[$api['name'].'_password'] = $api_login['password'];
    }
    $this->load->view('site_nav',$user_data);
    $this->user->load_nav($_SESSION['userid']);
    print_r($user_data);
    $this->load->view('org_account_info',$user_data);
    $this->load->view('site_foot');
  }

  function account_update() {
    if($_SERVER['REQUEST_METHOD']=="POST") {
      // VALIDATE SUBMITTED DATA
      $this->load->library('form_validation');   
      $rules = array(
		   array('field'=>'organization','label'=>'Organization','rules'=>'required|alpha_dash'),
		   array('field'=>'contact','label'=>'Contact','rules'=>'required|alpha_dash'),
		   array('field'=>'fname','label'=>'First Name','rules'=>'required|alpha_dash'),
		   array('field'=>'lname','label'=>'Last Name','rules'=>'required|alpha_dash'),
		   array('field'=>'phone1','label'=>'Phone Number','rules'=>'required|exact_length[3]'),
		   array('field'=>'phone2','label'=>'Phone Number','rules'=>'required|exact_length[3]'),
		   array('field'=>'phone3','label'=>'Phone Number','rules'=>'required|exact_length[4]'),
		   array('field'=>'email','label'=>'E-Mail','rules'=>'required|valid_email'),
		   array('field'=>'address1','label'=>'Address1','rules'=>'required|alpha_dash'),
		   array('field'=>'address2','label'=>'Address2','rules'=>'required|alpha_dash'),
		   array('field'=>'city','label'=>'City','rules'=>'required|alpha_dash'),
   		   array('field'=>'state','label'=>'State','rules'=>'required|alpha'),
		   array('field'=>'zip','label'=>'Zip Code','rules'=>'required|integer'),
		   array('field'=>'password1','label'=>'Password','rules'=>'matches[password2]')
		     );
      $this->form_validation->set_rules($rules);
      $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
      if($this->form_validation->run() == FALSE) {
		$user_data = $this->user->get_account($_SESSION['userid']);
		$this->load->view('site_nav',$user_data);
		$this->load->view('user_nav');
		$this->load->view('org_account_info',$user_data);
		$this->load->view('site_foot');
      }
      else {
	// UPDATE USER PROFILE
	$user_data = array(
			   'userid'=>$_SESSION['userid'],
			   'organization'=>$this->input->post('organization'),
			   'contact'=>$this->input->post('contact'),
			   'fname'=>$this->input->post('fname'),
			   'lname'=>$this->input->post('lname'),  
			   'phone1'=>$this->input->post('phone1'),
			   'phone2'=>$this->input->post('phone2'),
			   'phone3'=>$this->input->post('phone3'),
			   'email'=>$this->input->post('email'), 
			   'address1'=>$this->input->post('address1'),
			   'address2'=>$this->input->post('address2'),
			   'city'=>$this->input->post('city'),
			   'state'=>$this->input->post('state'),
			   'zip'=>$this->input->post('zip'),
			   'password'=>$this->input->post('password1')
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
	redirect('organization/account');
      }
    }
  }
}