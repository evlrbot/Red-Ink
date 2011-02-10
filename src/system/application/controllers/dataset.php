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

class Dataset extends Controller {
 
  function Dataset() {
    parent::Controller();
    $this->load->model("auth");
    $this->auth->access();
    $this->load->model("data");
    $this->load->model("user");
    $this->load->model("biz");
  }
  
  function edit($modid,$dataid) {
    if($_SERVER['REQUEST_METHOD'] == "POST") {
      $name = $this->db->escape($this->input->post("name"));
      $query = $this->db->escape($this->input->post("query"));
      $q = "UPDATE public.data SET name=$name, query=$query WHERE id=$dataid";
      $this->db->query($q);
      redirect("campaign/edit/$modid");
    }
    $this->load->view('site/head');
    $this->load->view('site/nav',$this->user->get_account($_SESSION['userid']));
    $this->load->view('site/body_start');
    $data = $this->data->get_data_set($dataid);
    $data['modid'] = $modid;
    $data['filters'] = $this->data->get_filters($dataid);
    $this->load->view('edit_dataset',$data);
    $this->load->view('site/body_stop');
    $this->load->view('site/foot');
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
    $this->load->view('site/head');
    $this->load->view('site/nav',$this->user->get_account($_SESSION['userid']));
    $this->load->view('site/body_start');
    $this->load->view('create_dataset',array('modid'=>$modid));
    $this->load->view('site/body_stop');
    $this->load->view('site/foot');
  }

  function addfilter($dataset_id,$filter_id=0,$modid) {
    if($dataset_id && $filter_id) {
      $this->data->add_filter($dataset_id,$filter_id);
    }
    if($dataset_id) {
      $this->load->view('site/head');
      $this->load->view('site/nav',$this->user->get_account($_SESSION['userid']));
      $this->load->view('site/body_start');
      $data['bizs'] = $this->biz->get_bizs();
      $data['modid'] = $modid;
      $data['dataset_id'] = $dataset_id;
      $this->load->view('add_filter',$data);
      $this->load->view('site/body_stop');
      $this->load->view('site/foot');      
    }
    else {
      redirect(site_url()."campaign/index");
    }
  }

  function removefilter($modid,$dataset_id,$filter_id) {
    if($modid && $dataset_id && $filter_id) {
      $this->data->remove_filter($dataset_id,$filter_id);
      redirect(site_url()."dataset/edit/$modid/$dataset_id");
    }
  }

  function add() {
    $this->load->view('site/head');
    $this->load->view('site/nav',$this->user->get_account($_SESSION['userid']));
    $this->load->view('site/body_start');
    $this->load->view('list_datasets',array('datasets'=>$this->data->get_data_sets()));
    $this->load->view('site/body_stop');
    $this->load->view('site/foot');   
  }

  function remove($modid,$dataid) {
    $query = "DELETE FROM public.module_data WHERE dataid=$dataid AND modid=$modid";
    $this->db->query($query);
    redirect("campaign/edit/$modid");
  }
}