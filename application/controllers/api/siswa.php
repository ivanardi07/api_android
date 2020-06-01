<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class siswa extends REST_Controller
{

    function index_get()
    {
        $nis = $this->get('nis');
        
        if ($nis != "") {
            $siswa = $this->db->get_where('siswa', array('nis' => $nis))->result();
        } else {
            $siswa = $this->db->get('siswa')->result();   
        }

        if ($siswa) {
            $this->response($siswa, REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'data tidak ditemukan'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function index_post()
    {
        $data = [
            'nis' => $this->post('nis'),
            'nama' => $this->post('nama'),
            'alamat' => $this->post('alamat'),
            'jenis_kelamin' => $this->post('jenis_kelamin'),
            'tanggal_lahir' => $this->post('tanggal_lahir'),
            'kelas' => $this->post('kelas')
        ];

        $this->db->insert('siswa', $data);
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
}
