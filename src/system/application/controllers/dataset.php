<?php
class Dataset extends Controller {
 
  function Dataset() {
    parent::Controller();
    $this->load->model("auth");
    $this->auth->access();
    $this->load->model("data");
    $this->load->model("user");
  }
  
  function index($dataid) {
    $user_data = $this->user->get_account($_SESSION['userid']);
    $this->load->view('site_nav',$user_data);
    $this->user->load_nav($_SESSION['userid']);
    $this->load->view('user_body_start');
    $data = $this->data->get_data_set($dataid);
    $this->load->view('edit_dataset',$data);
    $this->load->view('user_body_stop');
    $this->load->view('site_foot');
  }
  
  function edit($dataid) {
    if($_SERVER['REQUEST_METHOD'] == "POST") {
      $name = $this->db->escape($this->input->post("name"));
      $query = $this->db->escape($this->input->post("query"));
      $q = "UPDATE public.data SET name=$name, query=$query WHERE id=$dataid";
      $this->db->query($q);
    }
    redirect("dataset/index/$dataid");
  }

  function create() {
    if($_SERVER['REQUEST_METHOD'] == "POST") {
      $name = $this->db->escape($this->input->post("name"));
      $query = $this->db->escape($this->input->post("query"));
      $q = "INSERT INTO public.data (name,query) VALUES ($name,$query)";
      $this->db->query($q);
      $dataid = $this->db->insert_id();
    }
    redirect("dataset/index/$dataid");
  }
}