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

class Campaign extends Controller {
 
  function Campaign() {
    parent::Controller();
    $this->load->model("auth");
    $this->auth->access() ? "" : redirect(site_url('login'));
  }
  
  function index() {
    $this->load->view('site/head');
    $this->load->view('site/nav',$this->user->get_account($_SESSION['userid']));
    $this->load->view('site/body_start');
    $this->load->view('modules/list',array('data'=>$this->module->get_modules()));
    $this->load->view('site/body_stop');
    $this->load->view('site/foot');
  }

  function view($modid) {
    $this->load->view('site/head');
    $this->load->view('site/nav',$this->user->get_account($_SESSION['userid']));
    $this->load->view('site/body_start');
    $this->load->view('modules/view',array('module'=>$this->module->get_module($modid)));
    $this->load->view('site/body_stop');
    $this->load->view('site/foot');
  }

  function create() {
    if($_SERVER['REQUEST_METHOD'] == "POST") {
      $this->module->create_module($_SESSION['userid'],array($this->input->post('name'),$this->input->post('description')));
    }

    $this->load->view('site/head');
    $this->load->view('site/nav',$this->user->get_account($_SESSION['userid']));
    $this->load->view('site/body_start');
    $this->load->view('create_module');
    $this->load->view('site/body_stop');
    $this->load->view('site/foot');
  }

  function edit($modid) {
    if($_SERVER['REQUEST_METHOD'] == "POST") {
      $this->module->update_module($modid,$_POST);
    }
    $this->load->view('site/head');
    $this->load->view('site/nav',$this->user->get_account($_SESSION['userid']));
    $this->load->view('site/body_start');
    $data['filters'] = $this->module->get_filters($modid);
    $data['module'] = $this->module->get_module($modid);
    $this->load->view('modules/edit',$data);
    $this->load->view('site/body_stop');
    $this->load->view('site/foot');
  }
  
  function delete($modid) {
    $this->module->delete_module($modid);
    redirect("campaign/index");
  }

  function add($modid) {
    $this->module->add_user($_SESSION['userid'],$modid);    
    redirect('campaign/index');
  }

  function remove($modid) {
    $this->module->remove_user($_SESSION['userid'],$modid);        
    redirect('campaign/index');
  }

  function remove_filter($module_id,$filter_id=0) {
    if($filter_id && $module_id) {
      $this->module->remove_filter($module_id,$filter_id);
      redirect(site_url("campaign/edit/$module_id"));
    }
  }

  function add_filter($module_id,$filter_id=0) {
    if($filter_id) {
      $this->module->add_filter($module_id,$filter_id);
      redirect(site_url("campaign/edit/$module_id"));
    }
    $this->load->view('site/head');
    $this->load->view('site/nav',$this->user->get_account($_SESSION['userid']));
    $this->load->view('site/body_start');
    $data['filters'] = $this->filter->get_filters();
    $data['module_id'] = $module_id;
    $this->load->view('modules/add_filter',$data);
    $this->load->view('site/body_stop');
    $this->load->view('site/foot');
  }

  function embed($module_id) {
    $this->load->view('site/head_embed');
    $this->load->view('modules/embed',array('module'=>$this->module->get_module($module_id)));
    $this->load->view('site/foot');
  }
}