<?php
class RegisterOrg extends Controller 
{
  function RegisterOrg()
  {
    parent::Controller();
    $this->load->model("user");
    $this->load->library('form_validation');
    $this->load->helper('form');
  }
  
  function index()
  {
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
		   array('field'=>'zip','label'=>'Zip Code','rules'=>'required|integer')		   
		   );
    $this->form_validation->set_rules($rules);
    $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
    if($this->form_validation->run() == FALSE) { //FAIL
      $this->load->view('register_org');   
    }
    else { // SUCCESS
      $user_data = array('email'=>$this->input->post('email'),'password'=>$this->input->post('password1'));
	  print_r($user_data);
      /*
      if($this->user->account_create(&$user_data)) {
		$data = array('msg'=>'<p><em>You may now login with your new user credentials.</em</p>');
		$this->load->view('welcome_message.php',$data);   
      }
      else {
		$data = array('msg'=>'<p class="error">That email address is already assigned to a user account.</p>');
		$this->load->view('register_user.php',$data);         
      }
      */
    }		
  }
}