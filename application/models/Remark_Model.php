<?php

defined('BASEPATH') or exit('no direct script allowed');

class Remark_Model extends MY_Model {

    const db_table = 'remark';

    function __construct() {
        parent::__construct();
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

    public function check_remark($row_sche, $row_f) {
        return (bool) $this->get(array(
                    'schedule_id' => $row_sche->schedule_id,
                    'faculty_id' => $row_f->faculty_id,
                    'student_id' => $this->session->userdata('client_id'),
        ));
    }

}
