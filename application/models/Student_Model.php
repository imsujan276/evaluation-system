<?php

defined('BASEPATH') or exit('no direct script allowed');

class Student_Model extends MY_Model {

    const db_table = 'student';

    function __construct() {
        parent::__construct();
    }

    public function table_view() {
        $data = array();
        $rs = $this->my_select(self::db_table);
        if ($rs) {
            foreach ($rs->result() as $row) {
                array_push($data, array(
                    'id' => $row->student_id,
                    'school_id' => $row->student_school_id,
                    'lastname' => $row->student_lastname,
                    'name' => $row->student_name,
                    'course' => $row->student_course,
                    'status' => ($row->student_status) ? '<span class="badge badge-success">Enabled</span>' : '<span class="badge badge-important">Disabled</span>',
                    'option' => anchor(base_url('admin/student/schedule/' . $row->student_id), 'schedule list', array('class' => 'btn btn-success btn-mini')) . ' | '
                    . anchor(base_url('admin/student/change-status/' . $row->student_id), 'set ' . (($row->student_status) ? 'disable' : 'enable'), array('class' => 'btn btn-success btn-mini')) . ' | '
                    . anchor(base_url('admin/student#'), 'delete', array('class' => 'btn btn-success btn-mini')),
                ));
            }
        }
        $header = array(
            'id' => 'ID',
            'school_id' => 'School ID',
            'lastname' => 'Lastname',
            'name' => 'Name',
            'course' => 'Course',
            'status' => 'Status',
            'option' => 'Option',
        );
        return $this->my_table_view($header, $data);
    }

    public function add($values) {
        return $this->my_insert(self::db_table, $values);
    }

    public function get($column = NULL) {
        return $this->my_select(self::db_table, $column);
    }

    public function update($s, $w = NULL) {
        return $this->my_update(self::db_table, $s, $w);
    }

    public function validate_login() {

        $school_id = $this->input->post('school_id');
        $pin = $this->input->post('pin');

        $rs = $this->my_select(self::db_table, array(
            'student_school_id' => $school_id,
        ));

        if ($rs) {

            $row = $rs->row();

            if (password_verify($pin, $row->student_pin)) {
                if ($row->student_status) {
                    $this->session->set_userdata(array(
                        'client_id' => $row->student_id,
                        'client_school_id' => $row->student_school_id,
                        'client_course' => $row->student_course,
                        'client_fullname' => $row->student_lastname . ', ' . $row->student_name,
                        'validated_client' => TRUE,
                    ));
                    return TRUE;
                } else {
                    return 'Student Disabled.';
                }
            } else {
                return 'Invalid school id and/or pin.';
            }
        } else {
            return 'Invalid school id and/or pin.';
        }
    }

}
