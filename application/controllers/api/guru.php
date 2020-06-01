<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class guru extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    }

    //Menampilkan data guru
    function index_get() {
        // $id = $this->get('id_guru');
        // if ($id == '') {
        //     $guru = $this->db->get('guru')->result();
        // } else {
        //     $this->db->where('id_guru', $id);
        //     $guru = $this->db->get('guru')->result();
        // }
        // $this->response($guru, 200);
        
        $username = $this->get('username');
        
        if ($username != "") {
            $guru = $this->db->get_where('guru', array('username' => $username))->result();
        } else {
            $guru = $this->db->get('guru')->result();   
        }

        if ($guru) {
            $this->response($guru, REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'data tidak ditemukan'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    function index_post()
    {
        // $data = array (
        //     'id_guru'=> $this->post('id_guru'),   
        //     'nama' => $this->post('nama'),
        //     'alamat' => $this->post('alamat'),
        //     'jenis_kelamin' => $this->post('jenis_kelamin'),
        //     'no_telp' => $this->post('no_telp'),
        //     'foto' => $this->post('foto'),
        //     'username' => $this->post('username'),
        //     'password' => $this->post('password'));
        // $insert = $this->db->insert('guru', $data);
        // if($insert){
        //     $this->response($data, 200);
        // } else {
        //     $this->response(array('status' => 'fail', 502));
        // }

        
        $config = array(
            'upload_path' => "./foto/",
            'allowed_types' => "jpg|png|jpeg|webp",
            'overwrite' => true,
            'max_size' => 2048,
            'file_name' => 'foto_' . $this->post('username')
        );

        $this->load->library('foto', $config);
        $this->upload->do_upload('foto');

        $data = [
            'id_guru' => $this->post('id_guru'),
            'nama' => $this->post('nama'),
            'alamat' => $this->post('alamat'),
            'jenis_kelamin' => $this->post('jenis_kelamin'),
            'no_telp' => $this->post('no_telp'),
            'foto' => 'https://ivanardiyanto.000webhostapp.com/foto/foto_' . $this->post('username') . '.jpeg',
            'username' => $this->post('username'),
            'password' => $this->post('password')
        ];

        $this->db->insert('guru', $data);
        $row = $this->db->affected_rows();

        if ($row == 1) {
            $this->set_response($data, REST_Controller::HTTP_CREATED);
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'data gagal ditambahkan'
            ], REST_Controller::HTTP_BAD_GATEWAY);
        }
            
    }


    //Masukan function selanjutnya disini
}
?>