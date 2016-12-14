<?php

defined('BASEPATH') or exit('no direct script allowed');

class Semester_Model extends MY_Model {

    const db_table = 'semester';

    function __construct() {
        parent::__construct();
    }

    public function table_view() {
        $data = array();
        $semesters_rs = $this->my_select(self::db_table);
        if ($semesters_rs) {
            foreach ($semesters_rs->result() as $semester) {
                array_push($data, array(
                    'id' => $semester->semester_id,
                    'name' => $semester->semester_name,
                    'option' => anchor(base_url('admin/semester#'), 'update', array('class' => 'btn btn-success btn-mini')) . ' | '
                    . anchor(base_url('admin/semester#'), 'delete', array('class' => 'btn btn-success btn-mini')),
                ));
            }
        }
        $header = array(
            'id' => 'ID',
            'name' => 'Name',
            'option' => 'Option',
        );
        return $this->my_table_view($header, $data);
    }

    public function add($values) {
        return $this->my_insert(self::db_table, $values);
    }

    /**
     * for combo
     * @return array
     */
    public function combo() {
        $data = array();
        $rs = $this->my_select(self::db_table);
        if ($rs) {
            foreach ($rs->result() as $row) {
                $data[$row->semester_id] = $row->semester_name;
            }
        }
        return $data;
    }

    public function get($column = NULL) {
        return $this->my_select(self::db_table, $column);
    }

    public function update($s, $w = NULL) {
        return $this->my_update(self::db_table, $s, $w);
    }

}
