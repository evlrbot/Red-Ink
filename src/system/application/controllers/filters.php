<?php
class Filters extends Controller {
 
  function Filters() {
    parent::Controller();
    $this->load->model("auth");
    $this->auth->access() ? "" : redirect(site_url('login'));
  }

  function index() {
    $this->load->view('site/head');
    $this->load->view('site/nav',$this->user->get_account($_SESSION['userid']));
    $this->load->view('site/body_start');
    $data['filters'] = $this->filter->get_filters();
    $this->load->view('filters/list.php',$data);
    $this->load->view('site/body_stop');
    $this->load->view('site/foot');
  }

  function add() {
    $data = "";
    if($_SERVER['REQUEST_METHOD'] == "POST") {
      $this->load->library('form_validation');   
      $rules = array(
		     array('field'=>'name','label'=>'Name','rules'=>'required'),
		     array('field'=>'zipcode1','label'=>'Zip Code','rules'=>'integer|max_length[5]'),
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
		      'zip1'=>$this->input->post('zipcode1'),
		      'zip2'=>$this->input->post('zipcode2')
		      );
      	if($this->filter->create($data)) {
	  $data = array('msg'=>"<p class='success'><a href='/filters/edit/".$this->db->insert_id()."'>$data[name]</a> has been successfully added.</p>");
	}
      	else {
	  $data = array('msg'=>'<p class="error">That businss is already registered in our system.</p>');
	}
      }
    }
    $this->load->view('site/head');
    $this->load->view('site/nav',$this->user->get_account($_SESSION['userid']));
    $this->load->view('site/body_start');
    $this->load->view('filters/add',$data);
    $this->load->view('site/body_stop');
    $this->load->view('site/foot');
  }
  
  function edit($id) {
    if($_SERVER['REQUEST_METHOD'] == "POST") {
      $this->load->library('form_validation');   
      $rules = array(
		     array('field'=>'name','label'=>'Name','rules'=>'required'),
		     array('field'=>'zipcode1','label'=>'Zip Code','rules'=>'integer|max_length[5]'),
		     array('field'=>'zipcode2','label'=>'Zip Code','rules'=>'max_length[4]')		   
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
		      'zip1'=>$this->input->post('zipcode1'),
		      'zip2'=>$this->input->post('zipcode2')
		      );
      	if($this->filter->update($id, $data)) {
	  $data = array('msg'=>'<p><em>The business has been successfully updated.</em</p>');
	}
      }
    }
    $this->load->view('site/head');
    $this->load->view('site/nav',$this->user->get_account($_SESSION['userid']));
    $this->load->view('site/body_start');
    $data['filter'] = $this->filter->get_filter($id);
    $data['memo'] = $this->filter->get_memos($id);
    $this->load->view('filters/edit',$data);
    $this->load->view('site/body_stop');
    $this->load->view('site/foot');
  }
  
  function deletememo($filter_id,$memo_id) {
    $this->filter->deletememo($filter_id,$memo_id);
    redirect('/filters/edit/$filter_id');
  }

  function delete($id) {
    $this->filter->delete($id);
    redirect('/filters/index');
  }

  function deactivate($id) {
    $this->filter->deactivate($id);
    redirect('/filter/index');
  }

}