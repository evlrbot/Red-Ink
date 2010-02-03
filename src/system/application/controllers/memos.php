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
    redirect("/business/index");
  }
  
  function add($bizid) {
    if($_SERVER['REQUEST_METHOD'] == "POST") {
      $this->load->library('form_validation');   
      $rules = array(array('field'=>'memo','label'=>'memo','rules'=>'required'));
      $this->form_validation->set_rules($rules);
      $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
      if(!$this->form_validation->run() == FALSE) {
	if($this->memo->create($this->input->post('memo'))) {
	  $this->memo->add($bizid,$this->db->insert_id());
	  redirect("/business/edit/$bizid");
	}
      }
    }
    $user_data = $this->user->get_account($_SESSION['userid']);
    $this->load->view('site_nav',$user_data);
    $this->user->load_nav($_SESSION['userid']);
    $this->load->view('user_body_start');
    $this->load->view('create_memo',array('bizid'=>$bizid));
    $this->load->view('user_body_stop');
    $this->load->view('site_foot');
  }

  function remove($bizid,$memoid) {
    $this->memo->remove($bizid,$memoid);
    redirect("/business/edit/$bizid");
  }
}