<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class loginAdmin extends REST_Controller
{
    function index_post()
    {
        $data = array(
            'username' => $this->post('username'),
            'password' => $this->post('password')
        );

        $admin = $this->db->get_where('login_admin', array('username' => $data['username'], 'password' => $data['password']))->result();

        if ($admin) {
            $this->response($admin, REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'data tidak ditemukan'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
    
    function index_put() {
        $id = $this->put('id_login_admin');

        $data = array(
            'username' => $this->put('username'),
            'password' => $this->put('password')
        );
        
        var_dump($data);
        // $this->db->where('id_admin', $id);
        // $update = $this->db->update('admin', $data);
        
        // if ($update) {
        //     $this->response($data, 200);
        // } else {
        //     $this->response(array('status' => 'fail', 502));
        // }
        
        
    }
}
