<?php

defined('BASEPATH') or exit('no direct script allowed');

class Schedule_Model extends MY_Model {

    const db_table = 'schedule';

    function __construct() {
        parent::__construct();
        $this->load->helper(array('day', 'combobox'));
    }

    public function convrt_time($time) {

        return my_time_for_combo()[$time];
    }

    public function table_view_schedule($s_id) {
        $data = array();
        $rs_sche_ids = $this->get_schedule_ids($s_id);
        if ($rs_sche_ids) {
            foreach ($rs_sche_ids->result() as $row_ids) {
                $rs = $this->my_select(self::db_table, array('schedule_id' => $row_ids->schedule_id));
                if ($rs) {
                    $this->load->model(array('Faculty_Model', 'Subject_Model', 'Subject_Term_Model', 'Division_Model', 'Semester_Model', 'Batch_Model'));

                    foreach ($rs->result() as $row) {
                        $row_subj_term = $this->Subject_Term_Model->get(array('subject_term_id' => $row->subject_term_id))->row();
                        $row_subj = $this->Subject_Model->get(array('subject_id' => $row_subj_term->subject_id))->row();
                        $row_f = $this->Faculty_Model->get(array('faculty_id' => $row->faculty_id))->row();
                        array_push($data, array(
                            'id' => $row->schedule_id,
                            'subject_code' => $row_subj->subject_code,
                            'subject_decs' => $row_subj->subject_desc,
                            'start_time' => $this->convrt_time($row->schedule_start),
                            'end_time' => $this->convrt_time($row->schedule_end),
                            'day' => days($row),
                            'room' => $row->schedule_room,
                            'faculty' => $row_f->faculty_lastname . ', ' . $row_f->faculty_name,
                            'sem' => $this->Semester_Model->get(array('semester_id' => $row_subj_term->semester_id))->row()->semester_name,
                            'batch' => $this->Batch_Model->get(array('batch_id' => $row_subj_term->batch_id))->row()->batch_name,
                            'division' => $this->Division_Model->get(array('division_id' => $row_subj_term->division_id))->row()->division_name,
                            'option' => anchor(base_url('admin/batch#'), 'update', array('class' => 'btn btn-success btn-mini')) . ' | '
                            . anchor(base_url('admin/batch#'), 'delete', array('class' => 'btn btn-success btn-mini')),
                        ));
                    }
                }
            }
        }

        $header = array(
            'id' => 'ID',
            'subject_code' => 'Subject Code',
            'subject_decs' => 'Subject Description',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'day' => 'Day',
            'room' => 'Room',
            'faculty' => 'Faculty',
            'sem' => 'Semester',
            'batch' => 'Batch',
            'division' => 'Division',
            'option' => 'Option',
        );
        return $this->my_table_view($header, $data);
    }

    private function get_schedule_ids($s_id) {
        $this->load->model('Student_Schedule_Model');
        return $this->Student_Schedule_Model->get(array('student_id' => $s_id));
    }

    /**
     * for combo
     * @return array
     */
    public function combo($s_id) {
        $data = array();
        $rs = $this->my_select(self::db_table);
        if ($rs) {
            $this->load->model('Subject_Model');
            $this->load->model('Faculty_Model');
            $this->load->model('Subject_Term_Model');

            foreach ($rs->result() as $row) {
                //check if already added in student_schedule table where student_id
                $exist = $this->check_if_added($s_id, $row->schedule_id);
                if ($exist) {
                    //skip 1 lopp
                    continue;
                }
                $row_f = $this->Faculty_Model->get(array('faculty_id' => $row->faculty_id))->row();
                $row_sub_term = $this->Subject_Term_Model->get(array('subject_term_id' => $row->subject_term_id))->row();
                $row_sub = $this->Subject_Model->get(array('subject_id' => $row_sub_term->subject_id))->row();
                $data[$row->schedule_id] = $row_sub->subject_desc . ' | ' .
                        $this->convrt_time($row->schedule_start) . ' to ' .
                        $this->convrt_time($row->schedule_end) . ' | ' .
                        days($row) . ' | room: ' .
                        $row->schedule_room . ' | ' .
                        $row_f->faculty_lastname . ', ' . $row_f->faculty_name;
            }
        }
        return $data;
    }

    private function check_if_added($s_id, $sch_id) {
        $this->load->model('Student_Schedule_Model');
        //FALSE if no result
        return $this->Student_Schedule_Model->get(array(
                    'student_id' => $s_id,
                    'schedule_id' => $sch_id
        ));
    }

    public function table_view($f_id, $feed_back = FALSE) {
        $data = array();
        $rs = $this->my_select(self::db_table, array(
            'faculty_id' => $f_id
        ));
        if ($rs) {
            $this->load->model(array('Subject_Term_Model', 'Subject_Model'));
            //  $this->load->library('myclass');
            foreach ($rs->result() as $row) {
                $sub_term_row = $this->Subject_Term_Model->get(array('subject_term_id' => $row->subject_term_id))->row();
                $ubject_row = $this->Subject_Model->get(array('subject_id' => $sub_term_row->subject_id))->row();
                $option = '';
                if ($feed_back) {
                    $option = anchor(base_url('admin/feedback/result/' . $row->schedule_id), 'view result', array('class' => 'btn btn-success btn-mini'));
                } else {
                    $option = anchor(base_url('admin/faulty/schedule/' . $f_id), 'update', array('class' => 'btn btn-success btn-mini')) . ' | '
                            . anchor(base_url('admin/faulty/schedule/' . $f_id), 'delete', array('class' => 'btn btn-success btn-mini'));
                }
                array_push($data, array(
                    'id' => $row->schedule_id,
                    'subject_code' => $ubject_row->subject_code,
                    'subject_desc' => $ubject_row->subject_desc,
                    'start' => $this->convrt_time($row->schedule_start),
                    'end' => $this->convrt_time($row->schedule_end),
                    'room' => $row->schedule_room,
                    'day' => days($row),
                    'batch' => $this->Batch_Model->get(array('batch_id' => $sub_term_row->batch_id))->row()->batch_name,
                    'semester' => $this->Semester_Model->get(array('semester_id' => $sub_term_row->semester_id))->row()->semester_name,
                    'division' => $this->Division_Model->get(array('division_id' => $sub_term_row->division_id))->row()->division_name,
                    // 'branch' => $this->Branch_Model->get(array('branch_id' => $sub_term_row->branch_id))->row()->branch_name,
                    'option' => $option
                        )
                );
            }
        }
        $header = array(
            'id' => 'ID',
            'subject_code' => 'Subject Code',
            'subject_desc' => 'Subject Desc',
            'start' => 'Start Time',
            'end' => 'End time',
            'room' => 'Room',
            'day' => 'Day',
            'batch' => 'Batch',
            'semester' => 'Semester',
            'division' => 'Division',
            //  'branch' => 'Branch',
            'option' => 'Option',
        );
        return $this->my_table_view($header, $data);
    }

    public function add($values) {
        return $this->my_insert(self::db_table, $values);
    }

    public function get_all_schedules_($rs_subjects_term, $row_f) {
        $html = '';
        if ($rs_subjects_term) {
            $this->db->select('*');
            foreach ($rs_subjects_term->result() as $row) {
                $this->db->or_where('subject_term_id', $row->subject_term_id);
            }
            $this->db->where('faculty_id', $row_f->faculty_id);
            $rs_schedule = $this->db->get(self::db_table);
            if ($this->my_debug_viewer) {
                echo '<!-- ' . $this->db->last_query() . __FILE__ . __LINE__ . '-->';
            }
            if ($rs_schedule) {
                $this->load->library('table');
                $this->load->model('Subject_Model');
                $inc = 1;
                $data = array();
                foreach ($rs_schedule->result() as $row_sche) {

                    //check if already have remarks witch means its already done evaluating

                    $anchor = anchor(base_url('evaluate/index/' . $row_f->faculty_id . '/' . $row_sche->schedule_id), 'EVALUATE', array('class' => 'btn btn-success btn-mini'));
                    if ($this->check_remark($row_sche, $row_f)) {
                        // continue;
                        $anchor = 'Done';
                    }
                    $subject_term_row2 = $this->Subject_Term_Model->get(array('subject_term_id' => $row_sche->subject_term_id))->row();
                    //  $html .= '<p>' . anchor(base_url('faculty/schedule/' . $row_sche->schedule_id), $inc++ . '. ' . $subject_row2->subject_desc) . '</p>';
                    $subject_row2 = $this->Subject_Model->get(array('subject_id' => $subject_term_row2->subject_id))->row();
                    array_push($data, array(
                        'id' => $row_sche->schedule_id,
                        'subject_code' => $subject_row2->subject_code,
                        'subject_desc' => $subject_row2->subject_desc,
                        'start' => $row_sche->schedule_start,
                        'end' => $row_sche->schedule_end,
                        'day' => days($row_sche),
                        'room' => $row_sche->schedule_room,
                        'evaluate' => $anchor,
                    ));
                }
                $html .= $this->table__(array(
                    'id' => 'ID',
                    'subject_code' => 'Subject Code',
                    'subject_desc' => 'Subject Desc',
                    'start' => 'Time Start',
                    'end' => 'Time End',
                    'day' => 'Day',
                    'room' => 'Room',
                    'evaluate' => 'Evaluate',
                        ), $data);
            }
        }
        if ($html == "") {
            $html = 'no schedule';
        }
        return $html;
    }

    private function check_remark($row_sche, $row_f) {
        $this->load->model('Remark_Model');
        return (bool) $this->Remark_Model->check_remark($row_sche, $row_f);
    }

    public function table__($header, $data) {
        $this->load->library('table');
        $this->table->set_heading($header);
        $this->table->set_template(array(
            'table_open' => '<table id="rounded-corner" align="center">',
            //   'table_open' => '<table class="table table-bordered data-table">',
            'heading_cell_start' => '<th scope="col" class="rounded-company" align="center">',
            'cell_start' => '<td align=center>',
            'cell_alt_start' => '<td align=center>',
        ));
        return $this->table->generate($data);
    }

    public function get($column = NULL) {
        return $this->my_select(self::db_table, $column);
    }

}
