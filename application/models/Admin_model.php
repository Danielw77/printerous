<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {

	var $CI = NULL;

    const USER_TABLE = 'm_user';

    public function __construct() {
        $this->CI =& get_instance();
    }

    public function getAccountData($param = NULL, $id = NULL){

        if ($id != null) {
            $this->CI->db->where('id', $id);
        }
        
        $query = $this->CI->db->get(self::USER_TABLE);

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

    // public function getOrganizationPicData($id, $pic_id = NULL){

    //     $this->db->select('o.*, od.*');
    //     $this->db->from('m_organization as o');
    //     $this->db->join('m_organization_pic as od', 'o.id = od.organization_id');
    //     $this->db->where('o.id', $id);

    //     if ($pic_id != NULL) {
    //         $this->db->where('od.pic_id', $pic_id);
    //     }

    //     $query = $this->db->get();

    //     return $query->result();
    // }

    // public function getPicData($param = NULL, $id = NULL){

    //     if ($id != null) {
    //         $this->CI->db->where('pic_id', $id);
    //     }
        
    //     $query = $this->CI->db->get(self::TABLE_DETAIL_NAME);

    //     if ($query->num_rows() > 0) {

    //         if ($param != null) {
    //             foreach ($query->result() as $row) {
    //                 return $row->$param;
    //             }
    //         }
    //         else{
    //              return $query->result();
    //         }

    //     }else{

    //         return null;
    //     }
        
    // }
}
