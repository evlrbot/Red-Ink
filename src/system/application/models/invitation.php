<?php
/*
Red Ink - Consumer Analytics for People and Communities
Copyright (C) 2010  Ryan O'Toole

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU Affero General Public License as
published by the Free Software Foundation, either version 3 of the
License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

class Invitation extends Model {

  function Invitation() {
    parent::Model();
  }

  function sendMail($module_id,$mailList,$user_message,$sender,$sender_email) { 
	$this->load->library('email');   
	$this->load->helper('email');
	$mailTokens = explode(" ",$mailList);
	foreach($mailTokens as $receiver) {
	  if(valid_email(stripslashes($receiver))) {
            // RECORD INVITE
	    $query = "INSERT INTO public.invite (date_sent,module_id) VALUES (current_timestamp,$module_id)";
	    $this->db->query($query);
	    $invite_id = $this->db->insert_id();
	    $invite_url = site_url("SignUp/Index/$invite_id");

	    // SEND INVITE
	    $module = $this->module->get_module($module_id);
	    $headers = 'X-Mailer: PHP/' . phpversion() . "\r\n" .
	      "MIME-Version: 1.0\r\n" .
	      "Content-Type: text/html; charset=utf-8\r\n";
	    $headers .= "Bcc: rot@mit.edu\r\n";
	    $headers .= "From: \"$sender\" <$sender_email>";
	    $subject = "Join $sender on Red Ink!";
	    $to = stripslashes($receiver);
	    $msg = "<p>$sender has invited you to join the Red Ink Campaign:</p><p><b>$module[name] ~ $module[description]</b></p><pre>$user_message</pre><p>Click on the link below to join me on Red Ink!</p><p>$invite_url</p>";

	    if( mail( $to, $subject, $msg, $headers ) ){
	      // LOAD SUCCESS MESSAGE
	    }
	  }
	}
  }
  }

?>
