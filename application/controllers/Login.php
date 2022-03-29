<?php
Class Login extends CI_Controller{
    
    var $API ="";
    
    function __construct() {
        parent::__construct();
        //$this->API="http://localhost/rest_server/v1/login";
    }
    
    // menampilkan data kontak
    function index(){
      // $this->load->view('login');
       $data['datakontak'] = json_decode($this->curl->simple_get($this->API));
     if(!isset($_COOKIE[$cookie_name])) {
           // "Cookie named '" . $cookie_name . "' is not set!";
            $this->load->view('login');
        } else {
            // echo "Cookie '" . $cookie_name . "' is set!<br>";
            // echo "Value is: " . $_COOKIE[$cookie_name];
             redirect(base_url('/kontak'));
        }
       
    }

    // insert data kontak
    function login_proses(){
        
        if(isset($_POST['submit'])){
            $username=$this->input->post('username');
            $password=md5($this->input->post('password'));

                $login = $this->db->query("SELECT * from login where username='$username' AND password='$password' limit 1");
                 
                if($login->num_rows() > 0 ){
                    // echo "login berhasi";
                    // die;
                     $payload = array(
                                        'uid' => "putrab13",
                                        'status'   => "login",
                                        'grant'    => "admin");            
                    $key = "asdaduiddJ!2138*jdfajdbJASNJSNas:";
                    $token = JWT::encode($payload,$key);
                    $cookie_name = "token_app";
                    $cookie_value = $token;
                    //meyimpan token kedalam cookie
                    setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/","www.abc.com","true", "true"); // 86400 = 1 day

                
                redirect(base_url('/kontak'));
      }else{
            // echo "login gagal";
            //         die;
                    redirect(base_url('/login'));

      }
     
    }else{
        //  echo "parameter tidak ada";
        //             die;
    }
    
    
}
}