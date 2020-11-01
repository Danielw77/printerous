 <?php
 defined('BASEPATH') OR exit('No direct script access allowed');
 
 
 class User {

    var $CI = NULL;

    public function __construct() {
        $this->CI =& get_instance();
    }


    public function isLoggedIn(){

        if ($this->CI->session->userdata('id')) {

            return true;
        }else{

            return false;
        }
    }

    public function getUserData($param, $id = NULL, $email = NULL){

        if ($id != null) {
            $this->CI->db->where('id', $id);
        }
        else if($email != NULL){
             $this->CI->db->where('email', $email);
        }
        else{
            $this->CI->db->where('id', $this->CI->session->userdata('id'));
        }

        
        $query = $this->CI->db->get('m_user');

        if ($query->num_rows() > 0) {
            
             foreach ($query->result() as $row) {

                return $row->$param;

             }

        }else{

            return null;
        }
        
    }

    public function getUserDataAdmin($param = NULL, $id = NULL){

        if ($id != null) {
            $this->CI->db->where('id', $id);
        }
        
        $this->CI->db->where('role', 'ADM');
        $query = $this->CI->db->get('m_user');

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

    public function isAdmin(){

        $this->CI->db->where('id', $this->CI->session->userdata('id'));
        $query = $this->CI->db->get('m_user');

        if ($query->num_rows() > 0) {
            
            foreach ($query->result() as $row) {

                if ($row->role == 'ADM') {

                    return true;

                }else{

                    return false;
                }
            }

        }else{

            return null;
        }
        
    }

    public function isAccountManager(){

        $this->CI->db->where('id', $this->CI->session->userdata('id'));
        $query = $this->CI->db->get('m_user');

        if ($query->num_rows() > 0) {
            
            foreach ($query->result() as $row) {

                if ($row->role == 'AM') {

                    return true;

                }else{

                    return false;
                }
            }

        }else{

            return null;
        }
        
    }

    public function logout() {
        
        $data = $this->CI->session->all_userdata();

        foreach ($data as $row => $value) {
            
            $this->CI->session->unset_userdata($row);
        }

        $this->CI->session->set_flashdata('message', array(
            'alerttype' => 'info',
            'message' => 'Logged out'
        ));
        redirect('home');
     }
 }