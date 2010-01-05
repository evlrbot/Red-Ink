<?php

class Login extends Controller {

	function Login()
	{
		parent::Controller();	
	}
	
	function index()
	{
		$this->load->view('welcome_message');
	}
	
	function auth()
	{
		if($_SERVER['REQUEST_METHOD'] == "GET") {
		     // check l/p
		     // return cookie if valid
		     // return error if invalid
		     print_r($_GET);
		     print_r($_POST);
		     if($_POST['username'] == $_POST['password1']) {
		             $data['errmsg'] = "<div class='error'>Login successful.</div>";
		     }
		     else {
		     	     $data['errmsg'] = "<div class='error'>Invalid login / password.</div>";
		     }
		     $this->load->view('welcome_message',$data);
		}
		else {
		     redirect('Login');
		}

	}
}