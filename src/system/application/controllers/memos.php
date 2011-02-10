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

class Memos extends Controller {
  
  function Memos() {
    parent::Controller();
    $this->load->model("auth");
    $this->auth->access() ? "" : redirect(site_url('login'));
  }
  
  function index() {
    redirect("/filters/index");
  }
  
  function add($filter_id) {
    if($_SERVER['REQUEST_METHOD'] == "POST") {
      $this->load->library('form_validation');   
      $rules = array(array('field'=>'memo','label'=>'memo','rules'=>'required'));
      $this->form_validation->set_rules($rules);
      $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
      if(!$this->form_validation->run() == FALSE) {
	if($this->memo->create($this->input->post('memo'))) {
	  $this->memo->add($filter_id,$this->db->insert_id());
	  redirect("/filters/edit/$filter_id");
	}
      }
    }
    $this->load->view('site/head');
    $this->load->view('site/nav',$this->user->get_account($_SESSION['userid']));
    $this->load->view('site/body_start');
    $this->load->view('memo/add',array('filter_id'=>$filter_id));
    $this->load->view('site/body_stop');
    $this->load->view('site/foot');
  }

  function remove($filter_id,$memo_id) {
    $this->memo->remove($filter_id,$memo_id);
    redirect("/filters/edit/$filter_id");
  }
}