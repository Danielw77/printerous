<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Organization extends CI_Controller {

	const TABLE_NAME = 'm_organization';
	const TABLE_DETAIL_NAME = 'm_organization_pic';

	public function __construct(){
		parent::__construct();
		$this->load->model('Organization_model');
		$this->load->library('user');
		$this->load->library('template');
	}

	//---------------------------organization--------------------------------------------
	public function index()
	{
		if (!$this->user->isLoggedIn()) {
			redirect('home');
		}
		else{

			if ($this->user->isAccountManager()) {
				$assigned_organization = $this->user->getUserData('assigned_organization');

				$assigned_organization_arr = explode(',', $assigned_organization);

				$data['organization_data'] = $this->Organization_model->getOrganizationData(null, null, $assigned_organization_arr);

			}
			else{
				$data['organization_data'] = $this->Organization_model->getOrganizationData();
			}

			
			$this->template->render('organization', $data);
		}
	}

	public function add_organization(){

		$this->form_validation->set_rules('input_name','Name','required');
		$this->form_validation->set_rules('input_phone','Phone','required');
		$this->form_validation->set_rules('input_email','E-mail','trim|valid_email');
		$this->form_validation->set_rules('input_website','Website','required');

		//upload conf
		$config['upload_path']          = './application/assets/img/userupload';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['file_name']        	= time().'-'.date("Y-m-d").'-'.$_FILES['input_logo']['name'];
	    $config['overwrite']			= true;
	    $config['max_size']             = 2048; // 2MB

        $this->load->library('upload', $config);
		
		if ($this->form_validation->run() == TRUE) {

			$upload_data = $this->upload->data(); 
			$file_name =   $upload_data['file_name'];
			
			$encrypted_upload_path = $this->encrypt->encode($upload_data['full_path']);

			$data = array (
				'name' 			=> $this->input->post('input_name'),
				'phone' 		=> $this->input->post('input_phone'),
				'email' 		=> $this->input->post('input_email'),
				'website'		=> $this->input->post('input_website'),
				'logo' 			=> $encrypted_upload_path
			);

			if (!$this->upload->do_upload('input_logo')){

		        $msg = array(
					'alerttype' => 'error',
					'message' 	=> 'Failed to Add Organization ('.$this->upload->display_errors().')'
				);
		    }
		    else{
		    	try{
					$this->db->insert(self::TABLE_NAME, $data);

					$msg = array(
						'alerttype' => 'success',
						'message' 	=> 'Successfuly Add Organization' 
					);
				}catch(EXCEPTION $e)
				{
					$msg = array(
						'alerttype' => 'error',
						'message' 	=> 'Failed to Add Organization ('.$e.')'
					);
				}
		    }

			$this->session->set_flashdata('message', $msg);
			redirect('Organization');
		}else{
			$this->index();
		}
	}

	public function edit_organization(){

		$this->form_validation->set_rules('input_name','Name','required');
		$this->form_validation->set_rules('input_phone','Phone','required');
		$this->form_validation->set_rules('input_email','E-mail','trim|valid_email');
		$this->form_validation->set_rules('input_website','Website','required');

        $id = $this->input->get('id');

        $oldLogo = $this->Organization_model->getOrganizationData('logo', $id);
        $decodedOldLogo = $this->encrypt->decode($oldLogo);

        //upload conf
		$config['upload_path']          = './application/assets/img/userupload';
        $config['allowed_types']        = 'gif|jpg|png';

        if (!empty($_FILES['input_logo']['name'])) {
        	$config['file_name']        	= time().'-'.date("Y-m-d").'-'.$_FILES['input_logo']['name'];
        }
        
	    $config['overwrite']			= true;
	    $config['max_size']             = 2048; // 2MB

        $this->load->library('upload', $config);
		
		if ($this->form_validation->run() == TRUE) {

			$upload_data = $this->upload->data(); 
			$file_name =   $upload_data['file_name'];

			if (!empty($file_name)){
				$upload_path = $this->encrypt->encode($config['upload_path'].'/'.$file_name);

				//delete the old logo
				unlink($decodedOldLogo);

				//upload new logo
				$this->upload->do_upload('input_logo');
			}
			else{
				$upload_path = $oldLogo;
			}
			
			$encrypted_upload_path = $upload_path;

			$data = array (
				'name' 			=> $this->input->post('input_name'),
				'phone' 		=> $this->input->post('input_phone'),
				'email' 		=> $this->input->post('input_email'),
				'website'		=> $this->input->post('input_website'),
				'logo' 			=> $encrypted_upload_path
			);

	    	try{
				$this->db->where('id', $id);
				$this->db->update(self::TABLE_NAME, $data);

				$msg = array(
					'alerttype' => 'success',
					'message' 	=> 'Successfuly Edit Organization' 
				);
			}catch(EXCEPTION $e)
			{
				$msg = array(
					'alerttype' => 'error',
					'message' 	=> 'Failed to Edit Organization ('.$e.')'
				); 
			}
		    
			$this->session->set_flashdata('message', $msg);
			redirect('Organization');
		}else{
			$this->index();
		}
	}

	public function delete_organization()
	{
		$id = $this->input->get('id');

		$oldLogo = $this->Organization_model->getOrganizationData('logo', $id);
        $decodedOldLogo = $this->encrypt->decode($oldLogo);

		try{

			$this->db->where('id', $id);
			$this->db->delete(self::TABLE_NAME);

			//delete the old logo
			unlink($decodedOldLogo);

			$msg = array(
				'alerttype' => 'success',
				'message' 	=> 'Successfuly Delete Organization' 
			);
		}
		catch(Exeption $e){
			$msg = array(
				'alerttype' => 'error',
				'message' 	=> 'Failed to Delete Organization' 
			);
		}

		$this->session->set_flashdata('message', $msg);
		redirect('Organization');
	}

	//---------------------------end organization--------------------------------------------

	//---------------------------organization detail--------------------------------------------
	public function detail()
	{
		$id = $this->input->get('id');

		$isAuthorized = $this->isAuthorized($id);

		if (!$this->user->isLoggedIn() || !$isAuthorized) {
			redirect('home');
		}
		else{
			$data['organization_data'] = $this->Organization_model->getOrganizationData(null, $id);
			$data['pic_data'] = $this->Organization_model->getOrganizationPicData($id);
			$this->template->render('organizationdetail', $data);
		}
	}

	public function add_pic(){

		$id = $this->input->get('id');

		$this->form_validation->set_rules('input_name','Name','required');
		$this->form_validation->set_rules('input_phone','Phone','required');
		$this->form_validation->set_rules('input_email','E-mail','trim|valid_email');

		//upload conf
		$config['upload_path']          = './application/assets/img/userupload';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['file_name']        	= time().'-'.date("Y-m-d").'-'.$_FILES['input_avatar']['name'];
	    $config['overwrite']			= true;
	    $config['max_size']             = 2048; // 2MB

        $this->load->library('upload', $config);
		
		if ($this->form_validation->run() == TRUE) {

			$upload_data = $this->upload->data(); 
			$file_name =   $upload_data['file_name'];
			
			$encrypted_upload_path = $this->encrypt->encode($upload_data['full_path']);

			$data = array (
				'organization_id' 	=> $id,
				'user_name' 		=> $this->input->post('input_name'),
				'user_phone' 		=> $this->input->post('input_phone'),
				'user_email' 		=> $this->input->post('input_email'),
				'avatar' 			=> $encrypted_upload_path
			);

			if (!$this->upload->do_upload('input_avatar')){

		        $msg = array(
					'alerttype' => 'error',
					'message' 	=> 'Failed to Add PIC ('.$this->upload->display_errors().')'
				);
		    }
		    else{
		    	try{
					$this->db->insert(self::TABLE_DETAIL_NAME, $data);

					$msg = array(
						'alerttype' => 'success',
						'message' 	=> 'Successfuly Add PIC' 
					);
				}catch(EXCEPTION $e)
				{
					$msg = array(
						'alerttype' => 'error',
						'message' 	=> 'Failed to Add PIC ('.$e.')'
					);
				}
		    }

			$this->session->set_flashdata('message', $msg);
			redirect('Organization/detail?id='.$id);
		}else{
			redirect('Organization/detail?id='.$id);
		}
	}

	public function edit_pic(){

		$this->form_validation->set_rules('input_name','Name','required');
		$this->form_validation->set_rules('input_phone','Phone','required');
		$this->form_validation->set_rules('input_email','E-mail','trim|valid_email');

        $id = $this->input->get('id');
        $pic_id = $this->input->get('pic_id');

        $oldAvatar = $this->Organization_model->getPicData('avatar', $pic_id);
        $decodedOldAvatar = $this->encrypt->decode($oldAvatar);

        //upload conf
		$config['upload_path']          = './application/assets/img/userupload';
        $config['allowed_types']        = 'gif|jpg|png';

        if (!empty($_FILES['input_avatar']['name'])) {
        	$config['file_name']        	= time().'-'.date("Y-m-d").'-'.$_FILES['input_avatar']['name'];
        }
        
	    $config['overwrite']			= true;
	    $config['max_size']             = 2048; // 2MB

        $this->load->library('upload', $config);
		
		if ($this->form_validation->run() == TRUE) {

			$upload_data = $this->upload->data(); 
			$file_name =   $upload_data['file_name'];

			if (!empty($file_name)){
				$upload_path = $this->encrypt->encode($config['upload_path'].'/'.$file_name);

				//delete the old logo
				unlink($decodedOldAvatar);

				//upload new logo
				$this->upload->do_upload('input_avatar');
			}
			else{
				$upload_path = $oldAvatar;
			}
			
			$encrypted_upload_path = $upload_path;

			$data = array (
				'user_name' 		=> $this->input->post('input_name'),
				'user_phone' 		=> $this->input->post('input_phone'),
				'user_email' 		=> $this->input->post('input_email'),
				'avatar' 			=> $encrypted_upload_path
			);

	    	try{
				$this->db->where('pic_id', $pic_id);
				$this->db->update(self::TABLE_DETAIL_NAME, $data);

				$msg = array(
					'alerttype' => 'success',
					'message' 	=> 'Successfuly Edit PIC' 
				);
			}catch(EXCEPTION $e)
			{
				$msg = array(
					'alerttype' => 'error',
					'message' 	=> 'Failed to Edit PIC ('.$e.')'
				); 
			}
		    
			$this->session->set_flashdata('message', $msg);
			redirect('Organization/detail?id='.$id);
		}else{
			redirect('Organization/detail?id='.$id);
		}
	}

	public function delete_pic()
	{
		$id = $this->input->get('id');
		$pic_id = $this->input->get('pic_id');

		$oldAvatar = $this->Organization_model->getPicData('avatar', $pic_id);
        $decodedOldAvatar = $this->encrypt->decode($oldAvatar);

		try{

			$this->db->where('pic_id', $pic_id);
			$this->db->delete(self::TABLE_DETAIL_NAME);

			//delete the old logo
			unlink($decodedOldAvatar);

			$msg = array(
				'alerttype' => 'success',
				'message' 	=> 'Successfuly Delete Organization' 
			);
		}
		catch(Exeption $e){
			$msg = array(
				'alerttype' => 'error',
				'message' 	=> 'Failed to Delete Organization' 
			);
		}

		$this->session->set_flashdata('message', $msg);
		redirect('Organization/detail?id='.$id);
	}


	//---------------------------end organization detail--------------------------------------------

	public function isAuthorized($id){

		if ($this->user->isAccountManager()) {

			$assigned_organization = $this->user->getUserData('assigned_organization');

			$assigned_organization_arr = explode(',', $assigned_organization);

			if (in_array($id, $assigned_organization_arr)) {
				return true;
			}
			else{
				return false;
			}

		}
		else{
			return true;
		}

	}

}
