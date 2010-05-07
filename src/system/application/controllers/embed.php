<?php
class Embed extends Controller {
  function Embed() {
    parent::Controller();
  }
  
  function index($module_id) {
    $this->load->view('site/head_embed');
    $this->load->view('modules/embed',array('module'=>$this->module->get_module($module_id)));
    $this->load->view('site/foot');

  }
}