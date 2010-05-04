<?php
class Memos extends Controller {
  
  function Memos() {
    parent::Controller();
    $this->load->model("auth");
    $this->auth->access();
    $this->load->model("memo");
    $this->load->model("user");
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
    redirect("/business/edit/$filter_id");
  }
}