<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class absenGuru extends REST_Controller
{
    function index_get()
    {
        $username = $this->get('username');
        
        if ($username != "") {
            $guru = $this->db->query('SELECT * FROM absen_guru AS a INNER JOIN siswa s ON a.nis_siswa = s.nis WHERE a.username = "' . $username. '"')->result();
        } else {
            $guru = $this->db->query('SELECT * FROM absen_guru AS a INNER JOIN siswa s ON a.nis_siswa = s.nis')->result(); 
        }

        if ($guru) {
            $this->response($guru, REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'not found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function index_post()
    {
        $data = [
            'username' => $this->post('username'),
            'password' => $this->post('password'),
            'jam_login' => $this->post('jam_login'),
            'jam_logout' => $this->post('jam_logout'),
            'tanggal' => $this->post('tanggal'),
            'lokasi_latitude' => $this->post('lokasi_latitude'),
            'lokasi_longitude' => $this->post('lokasi_longitude'),
            'nis_siswa' => $this->post('nis_siswa'),
        ];

        $this->db->insert('absen_guru', $data);
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
