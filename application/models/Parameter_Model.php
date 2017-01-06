<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Parameter_Model extends CI_Model {

    const DB_TABLE = 'parameter';

    public $semester;
    public $year;
    public $course;

    public function __construct() {
        parent::__construct();
    }

    public function update($data) {
        //clear/truncate first
        $this->db->truncate('parameter');
        //insert

        $this->db->insert(self::DB_TABLE, $data);

        return (bool) $this->db->affected_rows();
    }

    public function get() {
        $rs = $this->db->get(self::DB_TABLE);
        if ($this->db->affected_rows() > 0) {
            $row = $rs->row();
            $this->semester = $row->semester;
            $this->year = $row->year;
            $this->course = $row->course;
        }
        return $this;
    }

    public function get_parameter($subject_obj) {
        if ($subject_obj) {
            $this->semester = $subject_obj->subject_semester;
            $this->year = $subject_obj->subject_year;
            $this->course = $subject_obj->subject_course;
        }
        return $this;
    }

}
