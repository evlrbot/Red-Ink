<?php
class Embed extends Controller {
  function Embed() {
    parent::Controller();
  }
  
  function index($module_id) {
    $module = $this->module->get_module($module_id);
    // is the module public
    // if not is the viewer logged in?
    // if so are they a member of the module?
    // if not, prompt them to join. 
    if(($module['public'] == 't') OR ($this->auth->access() && $this->module->has_user($module['id'],$_SESSION['userid']))) {
      $this->load->view('site/head_embed');
      $this->load->view('modules/embed',array('module'=>$module));
      $this->load->view('site/foot');
    }
    else {
      $this->load->view('site/head_embed');
      $this->load->view('modules/unauthorized');
      $this->load->view('site/foot');
    }
  }
}