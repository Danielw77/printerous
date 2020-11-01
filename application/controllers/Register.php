<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('Register_model');
		$this->load->library('template');
	}

	public function index()
	{
		if (!$this->user->isLoggedIn()) {
			$this->template->render('register', null);
		}
		else{
			redirect('home');
		}
	}

	public function register(){

		$this->form_validation->set_rules('input_email','E-mail','trim|valid_email|is_unique[m_user.email]');
		$this->form_validation->set_rules('input_password','Password','required');
		$this->form_validation->set_rules('input_repassword','Password Confirmation','matches[input_password]');
		
		
		if ($this->form_validation->run() == TRUE) {
			$encrypted_password = $this->encrypt->encode($this->input->post('input_password'));

			$data = array (
					'email' 		=> $this->input->post('input_email'),
					'nama' 			=> $this->input->post('input_name'),
					'password' 		=> $encrypted_password,
					'role'			=> 'NA'
			);

			$id = $this->Register_model->insert($data);

			if ($id > 0) {

				$this->session->set_flashdata('message','Email Registered!');
				redirect('register');
			}
		}else{
			$this->index();
		}
	}
}
