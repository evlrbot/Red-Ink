<?php

class Icons extends Controller {

	function _remap()
	{
		header('Content-Type: image/png');
		readfile($this->router->_mb_module.'icons/'.$this->uri->segment(2).'.png');
	}

}

/* End of file icons.php */
/* Location: ./system/application/modules/matchbox/controllers/icons.php */