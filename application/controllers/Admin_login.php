<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_login extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

        $this->data['identity'] = array('name' => 'identity',
            'id' => 'identity',
            'type' => 'text',
            'value' => $this->form_validation->set_value('identity'),
            'placeholder' => 'Email'
        );
        $this->data['password'] = array('name' => 'password',
            'id' => 'password',
            'type' => 'password',
            'placeholder' => 'Password'
        );



        //forgot password
        $this->data['type'] = $this->config->item('identity', 'ion_auth');
        // setup the input
        $this->data['identity'] = array('name' => 'identity',
            'id' => 'identity',
        );

        if ($this->config->item('identity', 'ion_auth') != 'email') {
            $this->data['identity_label'] = $this->lang->line('forgot_password_identity_label');
        } else {
            $this->data['identity_label'] = $this->lang->line('forgot_password_email_identity_label');
        }

        // set any errors and display the form
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

        $this->_render_page('admin/login', $this->data);
    }

}
