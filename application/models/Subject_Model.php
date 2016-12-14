<?php

defined('BASEPATH') or exit('no direct script allowed');

class Subject_Model extends MY_Model {

    const db_table = 'subject';

    public function __construct() {
        parent::__construct();
    }

    public function table_view() {
        $data = array();
        $rs = $this->my_select(self::db_table);
        if ($rs) {
            $this->load->model(array('Semester_Model', 'Batch_Model', 'Division_Model'));
            foreach ($rs->result() as $row) {
                array_push($data, array(
                    'id' => $row->subject_id,
                    'code' => $row->subject_code,
                    'name' => $row->subject_desc,
//                    'semester' => $this->Semester_Model->get(array('semester_id' => $row->semester_id))->row()->semester_name,
//                    'batch' => $this->Batch_Model->get(array('batch_id' => $row->batch_id))->row()->batch_name,
//                    'division' => $this->Division_Model->get(array('division_id' => $row->division_id))->row()->division_name,
                    'd' => anchor(base_url('admin/subject/term/' . $row->subject_id), 'View', array('class' => 'btn btn-success btn-mini')),
                    'option' => anchor(base_url('admin/faculty#'), 'update', array('class' => 'btn btn-success btn-mini')) . ' | '
                    . anchor(base_url('admin/faculty#'), 'delete', array('class' => 'btn btn-success btn-mini')),
                ));
            }
        }
        $header = array(
            'id' => 'ID',
            'code' => 'Subject Code',
            'name' => 'Subject Desc',
//            'semester' => 'Semester',
//            'batch' => 'Batch',
            'd' => 'Term',
            'option' => 'Opton'
        );
        return $this->my_table_view($header, $data);
    }

 
    public function add($values) {
        return $this->my_insert(self::db_table, $values);
    }

    public function update($s, $w = NULL) {
        return $this->my_update(self::db_table, $s, $w);
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
                $data[$row->subject_id] = $row->subject_desc;
            }
        }
        return $data;
    }

    public function get($column = NULL) {
        return $this->my_select(self::db_table, $column);
    }

}
