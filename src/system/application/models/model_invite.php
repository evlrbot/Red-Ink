class Model_invite extends Model {

	function Model_invite() {
	
		parent::Model();
	}

	function sendMail($mailList,$message,$sender){
		
		$this->load->helper('email');
		$mailTokens = explode(",", $mailList);
		foreach($mailTokens as $receiver){
		
			if (valid_email(stripslashes($receiver))) {
				$sent=mail(stripslashes($receiver),'Join '.$sender.' on RedInk!",$message. <a href="http://www.make-them-think.org/Main/Home">
				Join me on RedInk!</a>)
				echo $sent ? "Invitation sent!" : "Invitation failed. Please try again.";
			}

		}
		
		
		
	}

}
