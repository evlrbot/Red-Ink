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

class Main extends Controller {
 
  function Main() {
    parent::Controller();
    $this->load->model("auth");
    $this->auth->access();
    $this->load->model("user");
    $this->load->model("biz");
    $this->load->model("module");
  }

  function index() {
    $this->load->view('site/head');
    $this->load->view('site/nav');
    $this->load->view('site/body_start');
    $this->load->view('main/about');
    $this->load->view('site/body_stop');
    $this->load->view('site/foot');
  }

  function privacy() {
    $this->load->view('site/head');
    $this->load->view('site/nav');
    $this->load->view('site/body_start');
    $this->load->view('main/privacy');
    $this->load->view('site/body_stop');
    $this->load->view('site/foot');
  }

  function help() {
    $this->load->view('site/head');
    $this->load->view('site/nav');
    $this->load->view('site/body_start');
    $this->load->view('main/help');
    $this->load->view('site/body_stop');
    $this->load->view('site/foot');
  }
 
  function development() {
    $this->load->view('site/head');
    $this->load->view('site/nav');
    $this->load->view('site/body_start');
    $this->load->view('main/development');
    $this->load->view('site/body_stop');
    $this->load->view('site/foot');
  }
}