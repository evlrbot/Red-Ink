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
      // encrypt password
      $email = $_POST['email'];
      $passwd = md5($_POST['password1']);

      // update database with user credentials
      $this->load->database();
      $query = "SELECT * FROM public.user WHERE userid = '$email' LIMIT 1";
      $result = $this->db->query($query);
      if(count($result->result()) == 0) {
	$query = "INSERT INTO public.user (userid,password,email) VALUES ('$email','$passwd','$email')";
	$result = $this->db->query($query);
      }

      $data = array('msg'=>'<p><em>You may now login with your new user credentials.</em</p>');
      $this->load->view('welcome_message.php',$data);   
    }		
  }
}