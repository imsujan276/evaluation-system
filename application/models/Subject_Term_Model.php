<?php

defined('BASEPATH') or exit('no direct script allowed');

class Subject_Term_Model extends MY_Model {

    const db_table = 'subject_term';

    public function __construct() {
        parent::__construct();
    }

    public function table_view_term($sub_id) {
        $data = array();
        $rs = $this->my_select(self::db_table, array(
            'subject_id' => $sub_id
        ));
        if ($rs) {
            $this->load->model(array('Semester_Model', 'Batch_Model', 'Division_Model'));
            foreach ($rs->result() as $row) {
                array_push($data, array(
                    'id' => $row->subject_term_id,
                    'sem' => $this->Semester_Model->get(array('semester_id' => $row->semester_id))->row()->semester_name,
                    'ba' => $this->Batch_Model->get(array('batch_id' => $row->batch_id))->row()->batch_name,
                    'div' => $this->Division_Model->get(array('division_id' => $row->division_id))->row()->division_name,
                    'option' => anchor(base_url('admin/faculty#'), 'update', array('class' => 'btn btn-success btn-mini')) . ' | '
                    . anchor(base_url('admin/faculty#'), 'delete', array('class' => 'btn btn-success btn-mini')),
                ));
            }
        }
        $header = array(
            'id' => 'ID',
            'sem' => 'Semester',
            'ba' => 'Batch',
            'div' => 'Divsision',
            'option' => 'Opton'
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
            $this->load->model(array('Semester_Model', 'Batch_Model', 'Division_Model', 'Subject_Model'));
            foreach ($rs->result() as $row) {
                $subj = $this->Subject_Model->get(array('subject_id' => $row->subject_id))->row()->subject_desc;
                $sem = $this->Semester_Model->get(array('semester_id' => $row->semester_id))->row()->semester_name;
                $ba = $this->Batch_Model->get(array('batch_id' => $row->batch_id))->row()->batch_name;
                $div = $this->Division_Model->get(array('division_id' => $row->division_id))->row()->division_name;
                $data[$row->subject_term_id] = "Subject:$subj | Semester:$sem | Batch:$ba | Division:$div";
            }
        }
        return $data;
    }

    public function get($column = NULL) {
        return $this->my_select(self::db_table, $column);
    }

}
