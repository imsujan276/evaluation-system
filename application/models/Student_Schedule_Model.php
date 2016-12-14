<?php

defined('BASEPATH') or exit('no direct script allowed');

class Student_Schedule_Model extends MY_Model {

    const db_table = 'student_schedule';

    function __construct() {
        parent::__construct();
    }

    public function add($values) {
        return $this->my_insert(self::db_table, $values);
    }

    public function update($s, $w = NULL) {
        return $this->my_update(self::db_table, $s, $w);
    }

    public function get($column = NULL) {
        return $this->my_select(self::db_table, $column);
    }


}
