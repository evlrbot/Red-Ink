<?php

class RegisterUser extends Controller 
{
  
  function RegisterUser()
  {
    parent::Controller();	
  }
  
  function index()
  {
    $this->load->library('form_validation');   
    $rules = array(
		   array('field'=>'email','label'=>'E-Mail','rules'=>'required|valid_email'),
		   array('field'=>'password1','label'=>'Password','rules'=>'required|matches[password2]'),
		   array('field'=>'password2','label'=>'Verify Password','rules'=>'required')		       
		   );
    $this->form_validation->set_rules($rules);
    $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
    if($this->form_validation->run() == FALSE) {
      $this->load->view('register_user');   
    }
    else {
      $email = $_POST['email'];
      // CHECK IF USER ALREADY EXISTS
      $this->load->database();
      $query = "SELECT * FROM public.user WHERE email='$email' LIMIT 1";
      $result = $this->db->query($query);
      // IF NOT... ADD USER
      if(count($result->result()) == 0) {
	$passwd = md5($_POST['password1']); // MOVE THIS TO JQUERY FORM PRE PROCESSING
	$query = "INSERT INTO public.user (password,email,date_activated) VALUES ('$passwd','$email',current_timestamp)";
	$result = $this->db->query($query);
      }
      $data = array('msg'=>'<p><em>You may now login with your new user credentials.</em</p>');
      $this->load->view('welcome_message.php',$data);   
    }		
  }
}