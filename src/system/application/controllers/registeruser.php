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
      
//SET EMAIL CONFIGURATION PARAMETERS      
      
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
			  'mailtype'=>'text',
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
		  $this->email->message('Thank you for joining RedInk!  Please complete your registration by clicking the link below.');
		  //<br><a href="http://redink.media.mit.edu/registeruser"></a>
		  //<br>Sent ".date("D, j M, Y @ h:i:s A")."</p>";
		  $this->email->send();
		  echo $this->email->print_debugger();

      }
  }
}    


/*

//SEND EMAIL: 1

        $to = $_REQUEST['email'];
        $user_email = $this->input->post('email');
        $this->load->library('email');
        $this->email->from('melva@redink.media.mit.edu', 'Melva James');
        $this->email->to($to);
        $this->email->subject('RedInk Account Validation');
        $this->email->message('Thank you for joining RedInk!  Please complete your registration by clicking the link below.');
        $this->email->send();

*/


/*

//SEND EMAIL: 2

<?php
$to = $_REQUEST['sendto'] ;
$from = $_REQUEST['Email'] ;
$name = $_REQUEST['Name'] ;
$headers = "From: $from";
$subject = "Web Contact Data";

$fields = array();
$fields{"Name"} = "Name";
$fields{"Company"} = "Company";
$fields{"Email"} = "Email";
$fields{"Phone"} = "Phone";
$fields{"list"} = "Mailing List";
$fields{"Message"} = "Message";

$body = "We have received the following information:\n\n"; foreach($fields as $a => $b){ $body .= sprintf("%20s: %s\n",$b,$_REQUEST[$a]); }

$headers2 = "From: noreply@YourCompany.com";
$subject2 = "Thank you for contacting us";
$autoreply = "Thank you for contacting us. Somebody will get back to you as soon as possible, usualy within 48 hours. If you have any more questions, please consult our website at www.oursite.com";

if($from == '') {print "You have not entered an email, please go back and try again";}
else {
if($name == '') {print "You have not entered a name, please go back and try again";}
else {
$send = mail($to, $subject, $body, $headers);
$send2 = mail($from, $subject2, $autoreply, $headers2);
if($send)
{header( "Location: http://www.YourDomain.com/thankyou.html" );}
else
{print "We encountered an error sending your mail, please notify webmaster@YourCompany.com"; }
}
}
?> 

*/


/*

//SEND EMAIL: 3

date_default_timezone_set('America/New_York');
$p1 = $this->referee->get_player($p1);
$p2 = $this->referee->get_player($p2);
$to = $p2['email'];
$headers = "From: $p1[email]\r\n" .
      'X-Mailer: PHP/' . phpversion() . "\r\n" .
      "MIME-Version: 1.0\r\n" .
      "Content-Type: text/html; charset=utf-8\r\n";
$headers .= "Cc: $p1[email]\r\n";
$headers .= "Bcc: rot@media.mit.edu\r\n";
$headers .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
$subject = "Table Tennis: #$p1[rank] $p1[name] ~vs~ #$p2[rank] $p2[name] ";
$content = "<p>$p1[name] ($p1[email]) has challenged $p2[name] ($p2[email]) to a match of table tennis. Matches are best of 3 games to 11 points. The challenger (lower rank) must <a href='".site_url("scoreboard/login")."' target='_blank'>login</a> to fill out the win or loss after the match has been played.</p><p>Sent ".date("D, j M, Y @ h:i:s A")."</p>";
    mail($to, $subject, $content, $headers);

*/

/*

//SEND EMAIL: 4

		
		$this->load->library('email');
		date_default_timezone_set('America/New_York');
		$to = $this->input->post('email');
		$headers = "From: melva.james@gmail.com\r\n" .
      	  'X-Mailer: PHP/' . phpversion() . "\r\n" .
          "MIME-Version: 1.0\r\n" .
      	  "Content-Type: text/html; charset=utf-8\r\n";
		$headers .= "Cc: melva@alum.mit.edu\r\n";
		$headers .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
		$subject = "RedInk Account Registration";
		$content = "<p>Sent ".date("D, j M, Y @ h:i:s A")."</p>";
    	mail($to, $subject, $content, $headers);

*/


//		if ( ! defined('BASEPATH')) exit('No direct script access allowed');  


/*
		  -------------------------------------------------------------------
		  EMAIL CONFIG
		  -------------------------------------------------------------------
		  Configuration of outgoing mail server. 
*/
		     
/*	
		  $config['useragent']='Red Ink';  
		  $config['protocol']='postfix';  
		  $config['mailpath']='/usr/sbin/postfix';
		  $config['smtp_host']='';
		  $config['smtp_user']='';  
		  $config['smtp_pass']='';  
		  $config['smtp_port']='25';  
		  $config['smtp_timeout']='5';  
		  $config['wordwrap']=TRUE;  
		  $config['wrapchars']='76';
		  $config['mailtype']='text';
		  $config['charset']='iso-8859-1';  
		  $config['validate']=TRUE;
		  $config['priority']='1';
		  $config['crlf']="\r\n";
		  $config['newline']="\r\n"; 
		  $config['bcc_batch_mode']=FALSE; 
		  $config['bcc_batch_size']='200'; 
*/

/*

//OTHER MESSAGES

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