<?php

defined('BASEPATH') or exit('Direct Script is not allowed');

class Faculty extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index($f_id = NULL) {
        $row_f = $this->check_id_($f_id);
        $row_m = $this->my_header_client();
        $this->if_current_branch($row_m, $row_f);
        $this->load->view('myview', array(
            'msg' => '<br /><center><h4>Select a subject schedule from "'
            . $row_f->faculty_school_id . ' | ' . $row_f->faculty_lastname . ', '
            . $row_f->faculty_name . '" with current BATCH, SEMESTER, and DIVISION.</h4>'
            . $this->subjects($row_m, $row_f, $row_m),
        ));
        $this->load->view('admin/footer');
    }

    private function subjects($m, $row_f, $row_m) {
        //get all subject with 3 active area
        $this->load->model(array('Subject_Term_Model'));
        $rs_subjects_term = $this->Subject_Term_Model->get(array(
            'batch_id' => $row_m['batch']->batch_id,
            'semester_id' => $row_m['semester']->semester_id,
            'division_id' => $row_m['division']->division_id,
        ));

        //now get the schedule where all subject ids and faculty id
        $this->load->model('Schedule_Model');
        return $this->Schedule_Model->get_all_schedules_($rs_subjects_term, $row_f) . '</center><br /><br />';
    }

    private function if_current_branch($m, $f) {
        if ($m['branch']->branch_id == $f->branch_id) {
            //do nothing
        } else {
            show_404();
        }
    }

    public function schedeule($sched_id) {
        $row_sched = $this->check_id_sched($sched_id);
    }

    private function check_id_sched($id = NULL) {
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
