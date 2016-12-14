<?php

defined('BASEPATH') or exit('no direct script allowed');

class Score_Model extends MY_Model {

    const db_table = 'score';

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

    public function table_view($schedule_id) {
        $data = array();
        $header = array();


        $this->load->model(array('Question_Model', 'Category_Model', 'Student_Model'));

        $rs_q = $this->Question_Model->get();
        $rs_stud = $this->Student_Model->get();

        if ($rs_q) {
            foreach ($rs_q->result() as $row_q) {
                $header[$row_q->question_id] = $row_q->question_short;
            }
        }
        $header['stud'] = 'Student ID';


        foreach ($rs_stud->result() as $row_stud) {
            $tmp = array();
            $scored = FALSE;
            foreach ($header as $k => $v) {
                if ($k != 'stud') {
                    $rs_score = $this->my_select(self::db_table, array(
                        'schedule_id' => $schedule_id,
                        'question_id' => $k,
                        'student_id' => $row_stud->student_id
                    ));
                    if ($rs_score) {
                        $scored = TRUE;
                        $tmp[] = $rs_score->row()->score_value;
                    } else {
                        $tmp[] = 'xxx';
                    }
                }
            }
            $tmp[] = $row_stud->student_school_id;
            if ($scored) {
                array_push($data, $tmp);
            }
        }


        return $this->my_table_view($header, $data);
    }

}
