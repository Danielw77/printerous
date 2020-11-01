<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Organization_model extends CI_Model {

	var $CI = NULL;

	const TABLE_NAME = 'm_organization';
    const TABLE_DETAIL_NAME = 'm_organization_pic';

    public function __construct() {
        $this->CI =& get_instance();
    }

    public function getOrganizationData($param = NULL, $id = NULL, $idIn = NULL){

        if ($id != null) {
            $this->CI->db->where('id', $id);
        }

        if ($idIn != null) {
            $this->CI->db->where_in('id', $idIn);
        }
        
        $query = $this->CI->db->get(self::TABLE_NAME);

        if ($query->num_rows() > 0) {

            if ($param != null) {
                foreach ($query->result() as $row) {
                    return $row->$param;
                }
            }
            else{
                 return $query->result();
            }

        }else{

            return null;
        }
        
    }

    public function getOrganizationPicData($id, $pic_id = NULL){

        $this->db->select('o.*, od.*');
        $this->db->from('m_organization as o');
        $this->db->join('m_organization_pic as od', 'o.id = od.organization_id');
        $this->db->where('o.id', $id);

        if ($pic_id != NULL) {
            $this->db->where('od.pic_id', $pic_id);
        }

        $query = $this->db->get();

        return $query->result();
    }

    public function getPicData($param = NULL, $id = NULL){

        if ($id != null) {
            $this->CI->db->where('pic_id', $id);
        }
        
        $query = $this->CI->db->get(self::TABLE_DETAIL_NAME);

        if ($query->num_rows() > 0) {

            if ($param != null) {
                foreach ($query->result() as $row) {
                    return $row->$param;
                }
            }
            else{
                 return $query->result();
            }

        }else{

            return null;
        }
        
    }
}
