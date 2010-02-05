<?php
class Dataset extends Controller {
 
  function Dataset() {
    parent::Controller();
    $this->load->model("auth");
    $this->auth->access();
    $this->load->model("data");
    $this->load->model("user");
  }
  
  function edit($modid,$dataid) {
    if($_SERVER['REQUEST_METHOD'] == "POST") {
      $name = $this->db->escape($this->input->post("name"));
      $query = $this->db->escape($this->input->post("query"));
      $q = "UPDATE public.data SET name=$name, query=$query WHERE id=$dataid";
      $this->db->query($q);
      redirect("campaign/edit/$modid");
    }
    $user_data = $this->user->get_account($_SESSION['userid']);
    $this->load->view('site_nav',$user_data);
    $this->user->load_nav($_SESSION['userid']);
    $this->load->view('user_body_start');
    $data = $this->data->get_data_set($dataid);
    $data['modid'] = $modid;
    $this->load->view('edit_dataset',$data);
    $this->load->view('user_body_stop');
    $this->load->view('site_foot');
  }

  function create($modid) {
    if($_SERVER['REQUEST_METHOD'] == "POST") {
      $name = $this->db->escape($this->input->post("name"));
      $query = $this->db->escape($this->input->post("query"));
      $q = "INSERT INTO public.data (name,query) VALUES ($name,$query)";
      $this->db->query($q);
      $dataid = $this->db->insert_id();
      $q = "INSERT INTO public.module_data (modid,dataid) VALUES ($modid,$dataid)";
      $this->db->query($q);
      redirect("campaign/edit/$modid");
    }
    $user_data = $this->user->get_account($_SESSION['userid']);
    $this->load->view('site_nav',$user_data);
    $this->user->load_nav($_SESSION['userid']);
    $this->load->view('user_body_start');
    $this->load->view('create_dataset',array('modid'=>$modid));
    $this->load->view('user_body_stop');
    $this->load->view('site_foot');
  }

  function add() {
    $user_data = $this->user->get_account($_SESSION['userid']);
    $this->load->view('site_nav',$user_data);
    $this->user->load_nav($_SESSION['userid']);
    $this->load->view('user_body_start');
    $data['datasets'] = $this->data->get_data_sets();
    $this->load->view('list_datasets',$data);
    $this->load->view('user_body_stop');
    $this->load->view('site_foot');   
  }

  function remove($modid,$dataid) {
    $query = "DELETE FROM public.module_data WHERE dataid=$dataid AND modid=$modid";
    $this->db->query($query);
    redirect("campaign/edit/$modid");
  }
}