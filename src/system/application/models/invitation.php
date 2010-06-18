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
  
  function sendMail($mailList, $message,$sender) { 
	$this->load->library('email');   
	$this->load->helper('email');
    $mailTokens = explode(" ",$mailList);
    foreach($mailTokens as $receiver) {
      if(valid_email(stripslashes($receiver))) {
	# record email send in database; assign id.
	$query = "INSERT INTO public.invites (date_sent) VALUES (current_timestamp)";
	$this->db->query($query);
	$email_id = $this->db->insert_id();
	$base_url='http://dev.make-them-think.org/registerusercheck/#';
	## timestamp, id, activated flag
	# construct user sign up URL with email id: www.make-them-think.org/registerusercheck/#email_id
	# send email
	# modify user registration page to update email db. 
	$total_url=$base_url.$email_id;
	$subject = "Join $sender on Red Ink!";
	Echo "<html>";
	$msg =$message."\n\n"."Click on the link below to join me on Red Ink!\n\n".$total_url;
	if (mail(stripslashes($receiver),$subject,$msg)){
	}
	Echo "</html>";
	
      }
    }
  }
}

?>
