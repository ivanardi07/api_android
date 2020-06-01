<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class loginGuru extends REST_Controller
{
    function index_post()
    {
        $data = array(
            'username' => $this->post('username'),
            'password' => $this->post('password')
        );

        $guru = $this->db->get_where('guru', array('username' => $data['username'], 'password' => $data['password']))->result();

        if ($guru) {
            $this->response($guru, REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'data tidak ditemukan'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
}
