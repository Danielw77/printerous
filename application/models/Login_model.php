<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {

	function can_login($email, $password){

		$this->db->where('email', $email);
		$query = $this->db->get('m_user');

		if ($query->num_rows() > 0) {
			
			foreach ($query->result() as $row) {
					
				$decodedpass = $this->encrypt->decode($row->password);

				if ($password == $decodedpass) {
					
					$this->session->set_userdata('id', $row->id);

					if ($row->role == 'NA') {
						return 'normal';
					}
					else if ($row->role == 'AM') {
						return 'manager';
					}
					else{
						return 'admin';
					}

				}else{

					return 'Wrong Password';
				}
			}

		}else{

			return 'E-mail not Exist';
		}

	}
}
