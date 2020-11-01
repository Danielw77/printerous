 <?php
 defined('BASEPATH') OR exit('No direct script access allowed');
 
 
 class Template {

     var $CI = NULL;

     private $_whitelistURL = array(
        'home',
        'about',
        'contact',
        'login',
        'register',
        'forgotpassword',
        'resetpassword'
     );

     private $_multiPageURL = array(
        'organization',
        'organizationdetail'
     );
 
     public function __construct() {
         $this->CI =& get_instance();
         $this->CI->load->library('user');
     }


    function render($page, $data){
        
        $data['isLoggedIn'] = $this->CI->user->isLoggedIn();
        $data['isAdmin']    = $this->CI->user->isAdmin();
        $data['isAccountManager']  = $this->CI->user->isAccountManager();
        $data['userid']     = $this->CI->user->getUserData('id');
        $data['name']       = $this->CI->user->getUserData('nama');
        
        if ($data['isLoggedIn'] !== true && in_array($page, $this->_whitelistURL)) {

            $prefixPage = 'guest/';

        }else if(in_array($page, $this->_whitelistURL)){

            $prefixPage = 'guest/';
            
        }else{

            if ($data['isAdmin'] === true) {
                $prefixPage = 'admin/';

                if (in_array($page, $this->_multiPageURL)) {
                    $prefixPage = 'user/';
                }

            }
            else if($data['isAccountManager'] === true){
                $prefixPage = 'manager/';

                if (in_array($page, $this->_multiPageURL)) {
                    $prefixPage = 'user/';
                }
            }
            else{
                $prefixPage = 'user/';
            }
        }

        $this->CI->load->view('template/header', $data);
        $this->CI->load->view($prefixPage.$page, $data);
        $this->CI->load->view('template/footer');
    }

 }
 