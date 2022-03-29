<?php
Class Kontak extends CI_Controller{
    
    var $API ="";
    
    function __construct() {
        parent::__construct();
        $this->API="http://localhost/rest_server/v1/kontak";
    }
    
    // menampilkan data kontak
    function index(){
        $data['datakontak'] = json_decode($this->curl->simple_get($this->API));
        //die(var_dump($data));
        $this->load->view('kontak/list',$data);
    }
    
    // insert data kontak
    function create(){
        if(isset($_POST['submit'])){
            $data = array(
                'id'       =>  $this->input->post('id'),
                'nama'      =>  $this->input->post('nama'),
                'nomor'=>  $this->input->post('nomor'));
            $insert =  $this->curl->simple_post($this->API, $data, array(CURLOPT_BUFFERSIZE => 10)); 
            if($insert)
            {
                $this->session->set_flashdata('hasil','Insert Data Berhasil');
            }else
            {
               $this->session->set_flashdata('hasil','Insert Data Gagal');
            }
            redirect('kontak');
        }else{
            $this->load->view('kontak/create');
        }
    }
    
    // edit data kontak
    function edit(){
        if(isset($_POST['submit'])){
            $data = array(
                'id'       =>  $this->input->post('id'),
                'nama'      =>  $this->input->post('nama'),
                'nomor'=>  $this->input->post('nomor'));
            $update =  $this->curl->simple_put($this->API, $data, array(CURLOPT_BUFFERSIZE => 10)); 
            if($update)
            {
                $this->session->set_flashdata('hasil','Update Data Berhasil');
            }else
            {
               $this->session->set_flashdata('hasil','Update Data Gagal');
            }
            redirect('kontak');
        }else{
            $params = array('id'=>  $this->uri->segment(3));
            $data['datakontak'] = json_decode($this->curl->simple_get($this->API,$params));
            $this->load->view('kontak/edit',$data);
        }
    }
    
    // delete data kontak
    function delete($id){
        if(empty($id)){
            redirect('kontak');
        }else{
            $delete =  $this->curl->simple_delete($this->API, array('id'=>$id), array(CURLOPT_BUFFERSIZE => 10)); 
            if($delete)
            {
                $this->session->set_flashdata('hasil','Delete Data Berhasil');
            }else
            {
               $this->session->set_flashdata('hasil','Delete Data Gagal');
            }
            redirect('kontak');
        }
    }
}