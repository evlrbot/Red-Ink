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
		if($_POST) {
		     // check l/p
		     // return cookie if valid
		     // return error if invalid
		     $data['errmsg'] = "<div class='error'>Invalid login / password combo</div>";
		     $this->load_view('welcome_message',$data);
		}
		else {
		     $this->load_view('welcome_message');
		}
	}
}