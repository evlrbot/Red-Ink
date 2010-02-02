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
    $data = "";
    if($_SERVER['REQUEST_METHOD'] == "POST") {
      $this->load->library('form_validation');   
      $rules = array(
		     array('field'=>'name','label'=>'Name','rules'=>'required|alpha_dash'),
		     array('field'=>'address1','label'=>'Address 1','rules'=>'required|alpha_dash'),
		     array('field'=>'address2','label'=>'Address 2','rules'=>'alpha_dash'),
		     array('field'=>'city','label'=>'City','rules'=>'required|alpha_dash'),
		     array('field'=>'state','label'=>'State','rules'=>'required|alpha'),
		     array('field'=>'zipcode1','label'=>'Zip Code','rules'=>'required|integer|max_length[5]'),
		     array('field'=>'zipcode2','label'=>'Zip Code','rules'=>'integer|max_length[4]')		   
		     );
      $this->form_validation->set_rules($rules);
      $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
      if(!$this->form_validation->run() == FALSE) {
      	$data = array(
		      'name'=>$this->input->post('name'),
		      'address1'=>$this->input->post('address1'),
		      'address2'=>$this->input->post('address2'),
		      'city'=>$this->input->post('city'),
		      'state'=>$this->input->post('state'),
		      'zip'=>$this->input->post('zipcode1').'-'.$this->input->post('zipcode2')
		      );
      	if($this->biz->create($data)) {
	  $data = array('msg'=>'<p><em>The business has been successfully added.</em</p>');
	}
      	else {
	  $data = array('msg'=>'<p class="error">That business is already registered in our system.</p>');
	}
      }
    }
    $user_data = $this->user->get_account($_SESSION['userid']);
    $this->load->view('site_nav',$user_data);
    $this->user->load_nav($_SESSION['userid']);
    $this->load->view('user_body_start'); 
    $this->load->view('register_business',$data);
    $this->load->view('user_body_stop');
    $this->load->view('site_foot'); 
  }
  
  function delete($id) {
    $this->biz->delete($id);
    redirect('/business/index');
  }

  function deactivate($id) {
    $this->biz->deactivate($id);
    redirect('/business/index');
  }
}