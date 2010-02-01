<?php
class Business extends Controller {
 
  function Business() {
    parent::Controller();
    $this->load->model("auth");
    $this->auth->access();
    $this->load->model("user");
    $this->load->model("biz");
    $this->load->model("module");
  }

  function index() {
    $data = $this->user->get_account($_SESSION['userid']);
    $this->load->view('site_nav',$data);
    $this->user->load_nav($_SESSION['userid']);
    $this->load->view('user_body_start');
    $data['bizs'] = $this->biz->get_bizs();
    $this->load->view('list_bizs',$data);
    $this->load->view('user_body_stop');
    $this->load->view('site_foot');
  }

  function add() {
    if($_SERVER['REQUEST_METHOD'] == "POST") {
      // validate data from post    
      $this->load->library('form_validation');   
      $rules = array(
           array('field'=>'name','label'=>'Name','rules'=>'required|alpha_dash'),
		   array('field'=>'address1','label'=>'Address 1','rules'=>'required|alpha_dash'),
		   array('field'=>'address2','label'=>'Address 2','rules'=>'required|alpha_dash'),
		   array('field'=>'city','label'=>'City','rules'=>'required|alpha_dash'),
   		   array('field'=>'state','label'=>'State','rules'=>'required|alpha'),
		   array('field'=>'zipcode','label'=>'Zip Code','rules'=>'required|integer')		   
		   );
      $this->form_validation->set_rules($rules);
      $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
      // if create fails produce error result
      if($this->form_validation->run() == FALSE) {
 		//generate some error stuff
      }      
      else { // if not reload page with success message
      // pass data from post to create method
      ;
      	$data = array(
      	'name'=>$this->input->post('name'),
      	'address1'=>$this->input->post('address1'),
      	);
      	if($this->biz->create($data)) {
			$data = array('msg'=>'<p><em>Some new success text</em</p>');
		}
      	else {
			$data = array('msg'=>'<p class="error">That business is already registered in our system.</p>');
		}
      }
    }
	$data = $this->user->get_account($_SESSION['userid']);
	$this->load->view('site_nav',$data);
	 $this->user->load_nav($_SESSION['userid']);
	$this->load->view('register_business',$data);
	$this->load->view('site_foot'); 
  }
}