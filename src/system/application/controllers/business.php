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
    $this->load->view('site/head');
    $this->load->view('site/nav',$this->user->get_account($_SESSION['userid']));
    $this->load->view('site/body_start');
    $data['bizs'] = $this->biz->get_bizs();
    $this->load->view('list_businesses',$data);
    $this->load->view('site/body_stop');
    $this->load->view('site/foot');
  }

  function add() {
    $data = "";
    if($_SERVER['REQUEST_METHOD'] == "POST") {
      $this->load->library('form_validation');   
      $rules = array(
		     array('field'=>'name','label'=>'Name','rules'=>'required'),
		     array('field'=>'address1','label'=>'Address 1','rules'=>'required'),
		     array('field'=>'city','label'=>'City','rules'=>'required'),
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
		      'zip1'=>$this->input->post('zipcode1'),
		      'zip2'=>$this->input->post('zipcode2')
		      );
      	if($this->biz->create($data)) {
	  $data = array('msg'=>"<p class='success'><a href='/business/edit/".$this->db->insert_id()."'>$data[name]</a> has been successfully added.</p>");
	}
      	else {
	  $data = array('msg'=>'<p class="error">That business is already registered in our system.</p>');
	}
      }
    }
    $this->load->view('site/head');
    $this->load->view('site/nav',$this->user->get_account($_SESSION['userid']));
    $this->load->view('site/body_start');
    $this->load->view('create_business',$data);
    $this->load->view('site/body_stop');
    $this->load->view('site/foot');
  }
  
  function edit($id) {
    if($_SERVER['REQUEST_METHOD'] == "POST") {
      $this->load->library('form_validation');   
      $rules = array(
		     array('field'=>'name','label'=>'Name','rules'=>'required'),
		     array('field'=>'address1','label'=>'Address 1','rules'=>'required'),
		     array('field'=>'city','label'=>'City','rules'=>'required'),
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
		      'zip1'=>$this->input->post('zipcode1'),
		      'zip2'=>$this->input->post('zipcode2')
		      );
      	if($this->biz->update($id, $data)) {
	  $data = array('msg'=>'<p><em>The business has been successfully updated.</em</p>');
	}
      }
    }
    $this->load->view('site/head');
    $this->load->view('site/nav',$this->user->get_account($_SESSION['userid']));
    $this->load->view('site/body_start');
    $data['biz'] = $this->biz->get_biz($id);
    $data['memo'] = $this->biz->get_memos($id);
    $this->load->view('edit_business',$data);
    $this->load->view('site/body_stop');
    $this->load->view('site/foot');
  }
  
  function deletememo($bizid,$memoid) {
    $this->biz->deletememo($bizid,$memoid);
    redirect('/business/edit/$bizid');
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