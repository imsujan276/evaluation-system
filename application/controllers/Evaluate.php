<?php

defined('BASEPATH') or exit('Direct Script is not allowed');

class Evaluate extends MY_Controller {

    private $inputs_validation;

    public function __construct() {
        parent::__construct();
    }

    public function index($f_id = NULL, $sched_id = NULL) {
        $row_f = $this->check_id_($f_id);
        $row_sched = $this->check_id__sched($sched_id);

        $this->load->model('Remark_Model');
        if ($this->Remark_Model->check_remark($row_sched, $row_f)) {
            show_404();
        }
        $row = $this->my_header_client();

        $gen_table = $this->generate();

        $this->set_input($gen_table['inputs']);

        $this->load->library('form_validation');

        $this->form_validation->set_rules($this->inputs_validation);

        if ($this->form_validation->run()) {
            $msg = ($this->submit_score_process($row_f, $row_sched, $row)) ? '<h1>Form Submitted!</h1>' : '<h1>Failed to Submit..</h1>';

            $this->load->view('done', array(
                'msg' => $msg,
            ));
        } else {
            $this->load->view('form_evaluation', array(
                'my_input' => $gen_table,
                'faculty_id' => $f_id,
                'schedule_id' => $sched_id,
                'msg' => $this->tmp($row_f, $row_sched),
            ));
        }

        $this->load->view('admin/footer');
    }

    private function submit_score_process($row_f, $row_sched, $row) {
        $this->load->model(array('Score_Model', 'Remark_Model'));

        $student_id = $this->session->userdata('client_id');
        $faculty_id = $row_f->faculty_id;
        $schedule_id = $row_sched->schedule_id;
        $division_id = $row['division']->division_id;
        $semester_id = $row['semester']->semester_id;
        $branch_id = $row['branch']->branch_id;
        $batch_id = $row['batch']->batch_id;
        foreach ($this->inputs_validation as $k => $v) {
            if ($v['field'] != 'remarks') {
                $score_value = $this->input->post($v['field']);
                $question_id = $v['question_id'];

                //insert
                $data = array(
                    'student_id' => $student_id,
                    'faculty_id' => $faculty_id,
                    'schedule_id' => $schedule_id,
                    'division_id' => $division_id,
                    'semester_id' => $semester_id,
                    'branch_id' => $branch_id,
                    'batch_id' => $batch_id,
                    'score_value' => $score_value,
                    'question_id' => $question_id,
                );
                $this->Score_Model->add($data);
            }
        }
        // $msg = ($this->Faculty_Model->add($data)) ? 'Faculty Added!' : 'Failed to add.';
        $remarks = $this->input->post('remarks');
        //insert
        $data = array(
            'student_id' => $student_id,
            'faculty_id' => $faculty_id,
            'schedule_id' => $schedule_id,
            'division_id' => $division_id,
            'semester_id' => $semester_id,
            'branch_id' => $branch_id,
            'batch_id' => $batch_id,
            'remark_value' => $remarks,
        );
        $this->Remark_Model->add($data);

        return TRUE;
    }

    private function tmp($row_f, $row_sched) {
        $msg = '<br />';
        $msg .= 'Faculty: "<b>' . $row_f->faculty_school_id . ' | ' . $row_f->faculty_lastname . ', ' . $row_f->faculty_name . '</b>".<br />';
        $this->load->model(array('Subject_Model', 'Subject_Term_Model'));
        $row_subj_term = $this->Subject_Term_Model->get(array('subject_term_id' => $row_sched->subject_term_id))->row();
        $row_subj = $this->Subject_Model->get(array('subject_id' => $row_subj_term->subject_id))->row();
        $msg .= 'Subject Schedule: "<b>' . $row_subj->subject_desc . ' ' . $this->Schedule_Model->convrt_time($row_sched->schedule_start) . ' - ' . $this->Schedule_Model->convrt_time($row_sched->schedule_end);
        $msg .= ' ' . days($row_sched) . ' ' . $row_sched->schedule_room . '</b>".';
        return $msg . '<br /><br /><br />';
    }

    private function set_input($gen_table) {
        $this->inputs_validation = array();
        foreach ($gen_table as $k => $v) {

            foreach ($v['ques'] as $tmpo) {
                array_push($this->inputs_validation, array(
                    'label' => $tmpo['label'],
                    'rules' => $tmpo['rules'],
                    'field' => $tmpo['field'],
                    'question_id' => $tmpo['question_id'],
                ));
            }
        }
        array_push($this->inputs_validation, array(
            'label' => 'Remarks',
            'rules' => 'required|alpha_numeric_spaces|min_length[4]|max_length[250]',
            'field' => 'remarks',
        ));

        //  echo print_r($this->inputs_validation);
    }

    private function generate() {
        $this->load->helper('form');
        $inputs = array();
        $this->load->model(array('Category_Model', 'Question_Model'));
        $rs = $this->Category_Model->get();
        if ($rs) {
            $cat_count = 'A';
            $ques_count = 1;
            foreach ($rs->result() as $row) :
                $cat_countname = '' . $cat_count++ . '. ' . $row->category_name;
                $tmp = array();
                $tmp['cat'] = $cat_countname;
                $tmp['ques'] = array();
                $rs2 = $this->Question_Model->get(array('category_id' => $row->category_id));
                if ($rs2) {
                    $tmp2 = array();
                    foreach ($rs2->result() as $row2) :
                        $tmp2[$ques_count] = array(
                            'label' => $row2->question_short,
                            'question' => $row2->question_long,
                            'field' => 'my_input_' . $ques_count,
                            'rules' => 'required|numeric|numeric_0_to_9',
                            'question_id' => $row2->question_id
                        );
                        $ques_count++;
                    endforeach;
                    $tmp['ques'] = $tmp2;
                }
                array_push($inputs, $tmp);
            endforeach;
        }
        $my_input = array(
            'field_textarea' => 'remarks',
            'label_textarea' => 'Remarks',
            'button_name' => 'mybtn',
            'button_label' => 'Submit Evaluation Form',
            'inputs' => $inputs
        );
        return $my_input;
    }

    private function check_id__sched($id = NULL) {
        if (is_null($id)) {
            show_404();
        }

        $this->load->model('Schedule_Model');
        $rs = $this->Schedule_Model->get(array(
            'schedule_id' => $id
        ));
        if (!$rs) {
            show_404();
        }
        return $rs->row();
    }

    private function check_id_($id = NULL) {
        if (is_null($id)) {
            show_404();
        }

        $this->load->model('Faculty_Model');
        $rs = $this->Faculty_Model->get(array(
            'faculty_id' => $id
        ));
        if (!$rs) {
            show_404();
        }
        return $rs->row();
    }

}
