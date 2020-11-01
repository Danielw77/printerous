<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('Login_model');
		$this->load->model('User_model');
		$this->load->library('user');
		$this->load->library('template');
	}

	public function index()
	{
		if (!$this->user->isLoggedIn()) {
			$this->template->render('login', null);
		}
		else{
			redirect('home');
		}
	}

	public function login(){

		$this->form_validation->set_rules('input_email','E-mail','trim|valid_email');
		$this->form_validation->set_rules('input_password','Password','required');

		if ($this->form_validation->run() == TRUE) {

			$result = $this->Login_model->can_login($this->input->post('input_email'), $this->input->post('input_password'));

			if ($result == 'normal' || $result == 'manager' || $result == 'admin') {
				
				$this->session->set_flashdata('message', array(
					'type' => '',
					'alerttype' => 'success',
					'message' => 'Successfully Login'
				));

				if ($result == 'admin') {
					redirect('admin');
				}
				if ($result == 'manager') {
					redirect('organization');
				}
				else{
					redirect('home');
				}
				

			}else{

				$this->session->set_flashdata('message', array(
					'alerttype' => 'error',
					'message' => $result
				));
				redirect('login');
			}

		}else{
			$this->index();
		}

	}
}
