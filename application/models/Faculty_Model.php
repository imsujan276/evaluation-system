<?php

defined('BASEPATH') or exit('no direct script allowed');

class Faculty_Model extends MY_Model {

    const db_table = 'faculty';

    function __construct() {
        parent::__construct();
    }

    public function table_view_feed_back($branch_id) {
        //already loaded in faculty controller add_faculty_validation(){}
        //  $this->load->model('Branch_Model');
        $data = array();
        $rs = $this->my_select(self::db_table, array('branch_id' => $branch_id));
        if ($rs) {
            $this->load->model('Branch_Model');
            foreach ($rs->result() as $row) {
                $r_b = $this->Branch_Model->get(array('branch_id' => $row->branch_id))->row();
                array_push($data, array(
                    'id' => $row->faculty_id,
                    'school_id' => $row->faculty_school_id,
                    'lastname' => $row->faculty_lastname,
                    'name' => $row->faculty_name,
                    //'status' => ($row->faculty_status) ? 'Enabled' : 'Disabled',
                    //  'branch' => $r_b->branch_name,
                    'option' => anchor(base_url('admin/feedback/schedule/' . $row->faculty_id), 'subjects schedules', array('class' => 'btn btn-success btn-mini'))));
            }
        }
        $header = array(
            'id' => 'ID',
            'school_id' => 'School ID',
            'lastname' => 'Last Name',
            'name' => 'Name',
            //  'status' => 'Status',
            //  'branch' => 'Branch',
            'option' => 'Option',
        );
        return $this->my_table_view($header, $data);
    }

    public function table_view() {
        //already loaded in faculty controller add_faculty_validation(){}
        //  $this->load->model('Branch_Model');
        $data = array();
        $rs = $this->my_select(self::db_table);
        if ($rs) {
            $this->load->model('Branch_Model');
            foreach ($rs->result() as $row) {
                $r_b = $this->Branch_Model->get(array('branch_id' => $row->branch_id))->row();
                array_push($data, array(
                    'id' => $row->faculty_id,
                    'school_id' => $row->faculty_school_id,
                    'lastname' => $row->faculty_lastname,
                    'name' => $row->faculty_name,
                    'status' => ($row->faculty_status) ? 'Enabled' : 'Disabled',
                    'branch' => $r_b->branch_name,
                    'option' => anchor(base_url('admin/faculty/schedule/' . $row->faculty_id), 'subjects schedules', array('class' => 'btn btn-success btn-mini')) . ' | ' .
                    anchor(base_url('admin/faculty#'), 'update', array('class' => 'btn btn-success btn-mini')) . ' | '
                    . anchor(base_url('admin/faculty#'), 'delete', array('class' => 'btn btn-success btn-mini')),
                ));
            }
        }
        $header = array(
            'id' => 'ID',
            'school_id' => 'School ID',
            'lastname' => 'Last Name',
            'name' => 'Name',
            'status' => 'Status',
            'branch' => 'Branch',
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

}
