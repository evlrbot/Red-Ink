<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends Controller {

	function index()
	{
		$data['raised']   = $this->pledgie->raised();
		$data['base_url'] = $this->config->site_url($this->router->module).'/';
		$data['filepath'] = $this->router->_mb_module;
		$data['strict']   = $this->router->_mb_strict;
		$data['wiki']     = '<a href="http://codeigniter.com/wiki/Matchbox/">wiki</a>';

		$this->load->view('dashboard', $data);
	}

}

/* End of file dashboard.php */
/* Location: ./system/application/modules/matchbox/controllers/dashboard.php */