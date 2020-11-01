<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	const USER_TABLE = 'm_user';

	public function __construct(){
		parent::__construct();
		$this->load->library('template');
		$this->load->model('Admin_model');
		$this->load->model('Organization_model');
	}

	public function index()
	{
		if (!$this->user->isAdmin()) {
			redirect('home');
		}
		else{
			$this->template->render('admin', null);
		}
	}

	// ------------------------------------- start redirect-------------------------------------------

	public function accountmanagement()
	{
		if (!$this->user->isAdmin()) {
			redirect('home');
		}
		else{
			$data['account_data'] = $this->Admin_model->getAccountData();
			$data['organization_data'] = $this->Organization_model->getOrganizationData();

			$role = array(
				'ADM' => 'Admin',
				'AM' => 'Account Manager',
				'NA' => 'Normal Account'
			);

			$data['role'] = $role;

			$this->template->render('accountmanagement', $data);
		}
	}

	// ------------------------------------- end redirect-------------------------------------------

	public function add_account()
	{
		if (!$this->user->isAdmin()) {
			redirect('home');
		}
		else{

			$this->form_validation->set_rules('input_name','Name','required');
			$this->form_validation->set_rules('input_email','E-mail','trim|valid_email|is_unique[m_user.email]');
			$this->form_validation->set_rules('input_password','Password','required');
			$this->form_validation->set_rules('input_repassword','Password Confirmation','matches[input_password]');
			$this->form_validation->set_rules('select_role','Role','required');
			
			if ($this->form_validation->run() == TRUE) {

				$tokenid = md5(rand());
				$encrypted_password = $this->encrypt->encode($this->input->post('input_password'));

				$data = array (
						'email' 		=> $this->input->post('input_email'),
						'nama' 			=> $this->input->post('input_name'),
						'password' 		=> $encrypted_password,
						'role'			=> $this->input->post('select_role')
				);

				try{
					$this->db->insert(self::USER_TABLE, $data);

					$msg = array(
						'alerttype' => 'success',
						'message' 	=> 'Successfuly Add Account' 
					);
				}catch(EXCEPTION $e)
				{
					$this->logger->logError($e);

					$msg = array(
						'alerttype' => 'error',
						'message' 	=> 'Failed to Add Account' 
					);
				}

				$this->session->set_flashdata('message', $msg);
				redirect('Admin/accountmanagement');
			}else{
				$this->accountmanagement();
			}
		}
	}

	public function assignorganization(){

        $id = $this->input->get('id');

        $assignTo = $this->input->post('assignto');
        
    	$data = array (
			'assigned_organization' => implode(',', $assignTo)
		);

    	try{
			$this->db->where('id', $id);
			$this->db->update(self::USER_TABLE, $data);

			$msg = array(
				'alerttype' => 'success',
				'message' 	=> 'Successfuly Assign to Organization' 
			);
		}catch(EXCEPTION $e)
		{
			$msg = array(
				'alerttype' => 'error',
				'message' 	=> 'Failed to Assign to Organization ('.$e.')'
			); 
		}
        
	    
		$this->session->set_flashdata('message', $msg);
		redirect('Admin/accountmanagement');
	}

	public function delete_account()
	{
		$id = $this->input->get('id');

		try{

			$this->db->where('id', $id);
			$this->db->delete(self::USER_TABLE);

			$msg = array(
				'alerttype' => 'success',
				'message' 	=> 'Successfuly Delete Account' 
			);
		}
		catch(Exeption $e){
			$msg = array(
				'alerttype' => 'error',
				'message' 	=> 'Failed to Delete Account' 
			);
		}

		$this->session->set_flashdata('message', $msg);
		redirect('Admin/accountmanagement');
	}
}
