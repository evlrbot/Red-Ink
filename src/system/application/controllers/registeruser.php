<?php

class RegisterUser extends Controller{
 
  function RegisterUser(){
    parent::Controller();
    $this->load->model("user");
  }
    
  function index(){
    $this->load->library('form_validation');   
    $rules = array(
 		   	   array('field'=>'email','label'=>'E-Mail','rules'=>'required|valid_email'),
 		   	   array('field'=>'password1','label'=>'Password','rules'=>'required|matches[password2]'),
 		   	   array('field'=>'password2','label'=>'Verify Password','rules'=>'required')		       
 		   	 );
    $this->form_validation->set_rules($rules);
    $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
    if($this->form_validation->run() == FALSE){
        $this->load->view('register_user');   
    }   
      
      else{
      
/*

$sql = "SELECT *
        FROM table
        WHERE team_name = '$team_name';";

$result = mysql_query($sql) or die(mysql_error());

if(mysql_num_rows($result) > 0)
{
  // team already registered
}
else
{
  // team not registered
}

*/
	    if ($data = array('msg'=>'<p class="error">That email address is already assigned to a user account.</p>'){
 	      $this->load->view('register_user.php',$data); 
		}     
		  else{
		  	$config=Array(
		  	 'useragent'=>'Red Ink',  
			 'protocol'=>'postfix',  
			 'mailpath'=>'/usr/sbin/postfix',
			 'smtp_host'=>'',
			 'smtp_user'=>'',  
			 'smtp_pass'=>'',  
			 'smtp_port'=>'25',  
			 'smtp_timeout'=>'5',  
			 'wordwrap'=>TRUE,  
			 'wrapchars'=>'76',
			 'mailtype'=>'html',
			 'charset'=>'iso-8859-1',  
			 'validate'=>TRUE,
			 'priority'=>'1',
			 'crlf'=>"\r\n",
			 'newline'=>"\r\n", 
			 'bcc_batch_mode'=>FALSE, 
			 'bcc_batch_size'=>'200' 
			);
  
		  	$this->load->library('email', $config); 

		  	$user_email = $this->input->post('email');
		  	date_default_timezone_set('America/New_York');
		  	$this->email->from('melva.james@gmail.com', 'Melva James');
		  	$this->email->to($user_email);
		  	$this->email->subject('RedInk Account Validation');
		  	$this->email->message("<p>Thank you for joining RedInk!&nbsp;&nbsp;Please complete your registration by clicking the link below:</p><p><a href=\"http://redink.media.mit.edu/registeruser\">RedInk Account Registration</a><p>Sent ".date("D, j M, Y @ h:i:s A")."</p>");
		  	$this->email->send();
		  	echo $this->email->print_debugger();
          }
      }
  }
}

//OTHER MESSAGES 1

/*

$sql = "SELECT *
        FROM table
        WHERE team_name = '$team_name';";

$result = mysql_query($sql) or die(mysql_error());

if(mysql_num_rows($result) > 0)
{
  // team already registered
}
else
{
  // team not registered
}

*/

//OTHER MESSAGES 2

/*

      elseif ($this->form_validation->run() == TRUE){
        $data = array('msg'=>'<p class="error">That email address is already assigned to a user account.</p>');
 	    $this->load->view('register_user.php',$data); 
      } 
        
       $user_data = array('email'=>$this->input->post('email'),'password'=>$this->input->post('password1'));
       if($this->user->account_create(&$user_data)){
 	    $data = array('msg'=>'<p><em>You may now login with your new user credentials.</em</p>');
 	    $this->load->view('login',$data);   
       }
*/