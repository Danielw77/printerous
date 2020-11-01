<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->library('template');
		$this->load->library('user');
	}  

	public function index()
	{
		$data['username'] = $this->user->getUserData('nama');
		$this->template->render('home', $data);
	}

	public function about()
	{
		$this->template->render('about', null);
	}

	public function logout(){

		$this->user->logout();
	}
}
