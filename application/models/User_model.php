<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

	function isEmailExist($email){
		$this->db->where('email', $email);
		$query = $this->db->get('m_user');

		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}	

	function update($param, $where, $data){

		$this->db->where($param, $where);
		$this->db->update('m_user', $data);
	}
}
