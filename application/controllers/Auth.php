<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller {

    private $data;

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        if ($this->ion_auth->logged_in() and ! $this->ion_auth->is_admin()) {
            // redirect them to the login page
            redirect(base_url(), 'refresh');
        } elseif ($this->ion_auth->is_admin()) { // remove this elseif if you want to enable this for non-admins
            // redirect them to the home page because they must be an administrator to view this
            // return show_error('You must be an administrator to view this page.');
            redirect(base_url('dashboard'), 'refresh');
        } else {
            redirect(base_url('auth/login'), 'refresh');
        }
    }

    private function check_log() {
        if ($this->ion_auth->is_admin()) {
            redirect('dashboard', 'refresh');
        } else if ($this->ion_auth->logged_in()) {
            redirect('/', 'refresh');
        }
    }

    private function set_data() {
        // the user is not logging in so display the login page
        // set the flash data error message if there is one
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
    }

    // log the user in
    public function login() {
        $this->check_log();
        $this->data['title'] = $this->lang->line('login_heading');

        //validate form input
        $this->form_validation->set_rules('identity', str_replace(':', '', $this->lang->line('login_identity_label')), 'required');
        $this->form_validation->set_rules('password', str_replace(':', '', $this->lang->line('login_password_label')), 'required');

        if ($this->form_validation->run() == true) {
            // check to see if the user is logging in
            // check for "remember me"
            $remember = (bool) $this->input->post('remember');

            if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember)) {
                //if the login is successful
                //redirect them back to the home page
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect('dashboard', 'refresh');
            } else {
                // if the login was un-successful
                // redirect them back to the login page
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect('auth/login', 'refresh'); // use redirects instead of loading views for compatibility with MY_Controller libraries
            }
        } else {
            $this->set_data();
            $this->_render_page('admin/login', $this->data);
        }
    }

    public function forgot_password() {
        // setting validation rules by checking whether identity is username or email
        if ($this->config->item('identity', 'ion_auth') != 'email') {
            $this->form_validation->set_rules('identity', $this->lang->line('forgot_password_identity_label'), 'required');
        } else {
            $this->form_validation->set_rules('identity', $this->lang->line('forgot_password_validation_email_label'), 'required|valid_email');
        }


        if ($this->form_validation->run() == false) {

            $this->set_data();
            $this->_render_page('admin/login', $this->data);
        } else {
            $identity_column = $this->config->item('identity', 'ion_auth');
            $identity = $this->ion_auth->where($identity_column, $this->input->post('identity'))->users()->row();

            if (empty($identity)) {

                if ($this->config->item('identity', 'ion_auth') != 'email') {
                    $this->ion_auth->set_error('forgot_password_identity_not_found');
                } else {
                    $this->ion_auth->set_error('forgot_password_email_not_found');
                }

                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect("auth/login", 'refresh');
            }

            // run the forgotten password method to email an activation code to the user
            $forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});

            if ($forgotten) {
                // if there were no errors
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect("auth/login", 'refresh'); //we should display a confirmation page here instead of the login page
            } else {
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect("auth/login", 'refresh');
            }
        }
    }

    // log the user out
    public function logout() {
        $this->data['title'] = "Logout";

        // log the user out
        $logout = $this->ion_auth->logout();
        // redirect them to the login page
        $this->session->set_flashdata('message', $this->ion_auth->messages());
        redirect('auth/login', 'refresh');
    }

}
