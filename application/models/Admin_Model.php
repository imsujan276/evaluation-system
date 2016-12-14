<?php

defined('BASEPATH') or exit('no direct script allowed');

class Admin_Model extends MY_Model {

    const db_table = 'admin';

    function __construct() {
        parent::__construct();
    }

    public function get($column = NULL) {
        return $this->my_select(self::db_table, $column);
    }

    public function update($set, $w = NULL) {
        return $this->my_update(self::db_table, $set, $w);
    }

    public function add($values) {
        return $this->my_insert(self::db_table, $values);
    }

    /**
     * validation rules
     * just call this in insert or update admin data,
     * so less repeated in codings
     * so happy :D, so neat
     * 
     * @access private
     */
    private function admin_validation() {
        //need to load this database loader here, bacause validation need to check if username is exist in admin table
        $this->load->database();

        $this->form_validation->set_rules(
                'fullname', 'Fullname', 'required|regex_match[' . FULLNAME_REGEX . ']|min_length[8]', array(
            'required' => 'You have not provided %s.',
            'regex_match' => 'Invalid %s format.'
                )
        );
        $this->form_validation->set_rules(
                'username', 'Username', 'required|is_unique[admin.admin_username]|regex_match[' . USERNAME_REGEX . ']', array(
            'required' => 'You have not provided %s.',
            'is_unique' => 'This %s already exists.',
            'regex_match' => 'Invalid %s format.'
                )
        );
        $this->form_validation->set_rules(
                'password', 'Password', 'required|regex_match[' . PASSWORD_REGEX . ']', array(
            'required' => 'You have not provided %s.',
            'regex_match' => PASSWORD_MSG_REGEX
                )
        );
    }

    /**
     * only this model to allowed to set add admin view
     * form view of adding admin
     * @access private
     */
    private function admin_form_view() {
        $my_form = array(
            'caption' => 'Add Admin',
            'action' => '',
            'button_name' => 'addadmin',
            'button_title' => 'Add Admin',
        );

        $my_inputs = array(
            'fullname' => array(
                'title' => 'Fullname',
                'type' => 'text',
                'value' => NULL,
            ),
            'username' => array(
                'title' => 'Username',
                'type' => 'text',
                'value' => NULL,
            ),
            'password' => array(
                'title' => 'Password',
                'type' => 'text',
                'value' => NULL,
            )
        );
        $this->load->model('Form_Model');
        $this->Form_Model->form_view($my_form, $my_inputs);
    }
//
//    public function add() {
//        $this->load->library('form_validation');
//        //initialise validation
//        $this->admin_validation();
//        $this->form_validation->set_error_delimiters('<span class="label label-warning">', '</span>');
//        if (!$this->form_validation->run()) {
//            //admin form view
//            $this->admin_form_view();
//        } else {
//            $admin = array(
//                'admin_fullname' => $this->input->post('fullname'),
//                'admin_username' => $this->input->post('username'),
//                'admin_password' => password_hash($this->input->post('password'), TRUE),
//                'admin_status' => 1,
//            );
//            $msg = ($this->insert_admin($admin)) ? 'Admin added!.' : 'Failed to add admin.';
//            //load view to promt insert status 
//            $this->load->view('admin/done', array(
//                'msg' => $msg,
//            ));
//        }
//    }

    /**
     * 
     * @return boolean|string TRUE if success|string if failed with corresponding invalid massage for view
     */
    public function validate_login() {

        $usr = $this->input->post('username');
        $pwd = $this->input->post('password');

        $admin = $this->my_select(self::db_table, array(
            'admin_username' => $usr,
        ));

        if ($admin) {

            $admin_ = $admin->row();

            if (password_verify($pwd, $admin_->admin_password)) {
                if ($admin_->admin_status) {
                    $this->session->set_userdata(array(
                        'admin_id' => $admin_->admin_id,
                        'admin_fullname' => $admin_->admin_fullname,
                        'validated_admin' => TRUE,
                    ));
                    return TRUE;
                } else {
                    return 'User Disabled.';
                }
            } else {
                return 'Invalid username and/or password.';
            }
        } else {
            return 'Invalid username and/or password.';
        }
    }

}
