<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register_model extends CI_Model {

	function insert($data){
		$this->db->insert('m_user', $data);
		return $this->db->insert_id();
	}


	function verify_email($key){
		$this->db->where('tokenid', $key);
		$this->db->where('is_verified', 0);
		$query = $this->db->get('m_user');

		if($query->num_rows() > 0){

			$data = array(
				'is_verified'	=>	1,
			);
			$this->db->where('tokenid', $key);
			$this->db->update('m_user', $data);
			return true;
		}else{
			return false;
		}

	}	

}
