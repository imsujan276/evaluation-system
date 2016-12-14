<?php

defined('BASEPATH') or exit('Direct Script is not allowed');

class Student extends MY_Controller {

    private $my_input;
    private $my_input_addsched;

    public function __construct() {
        parent::__construct();
    }

    private function validation() {
        $this->load->database();
        $this->my_input = array(
            array(
                'field' => 'firstname',
                'label' => 'First Name',
                'rules' => 'required|human_name|min_length[4]|max_length[20]',
                'type' => 'text'
            ),
            array(
                'field' => 'lastname',
                'label' => 'Last Name',
                'rules' => 'required|human_name|min_length[4]|max_length[20]',
                'type' => 'text'
            ),
            array(
                'field' => 'school_id',
                'label' => 'School ID',
                'rules' => 'required|school_id|is_unique[student.student_school_id]|is_unique[faculty.faculty_school_id]',
                'type' => 'text',
            ),
            array(
                'field' => 'course',
                'label' => 'Course',
                'rules' => 'required|in_list[college,highschool,elementary]',
                'type' => 'combo',
                'combo_value' => array(
                    'college' => 'College',
                    'highschool' => 'High School',
                    'elementary' => 'Elementary',
                )
            ),
            array(
                'field' => 'pin',
                'label' => 'Pin',
                'rules' => 'required|numeric|exact_length[6]',
                'type' => 'text',
            ),
        );
    }

    public function change_status($s_id = NULL) {
        $row = $this->check_id_($s_id);
        $this->Student_Model->update(array(
            'student_status' => ($row->student_status) ? FALSE : TRUE
                ), array('student_id' => $s_id,));
        $this->index();
    }

    private function validation_add_sched($s_id) {
        $this->load->model('Schedule_Model');
        $this->my_input_addsched = array(
            array(
                'field' => 'schedule_id',
                'label' => 'Schedule',
                'rules' => 'required',
                'type' => 'combo',
                'combo_value' => $this->Schedule_Model->combo($s_id)
            ),
        );
    }

    private function form() {
        $this->load->helper('form');
        $myform = array(
            'action' => 'student/add',
            'button_name' => 'add_fstudent_button',
            'button_label' => 'Add Student',
            'attr' => $this->my_input,
        );
        $this->load->view('admin/form', array(
            'myform' => $myform,
            'caption' => 'Add Student'
        ));
    }

    public function index() {
        $this->my_header_view_admin();

        $this->load->model('Student_Model');
        $this->load->view('admin/table', array(
            'caption' => 'Student List',
            'table' => $this->Student_Model->table_view(),
            'href' => 'student/add',
            'button_label' => 'Add Student'
        ));
        $this->load->view('admin/footer2', array(
            'controller' => 'table'
        ));
    }

    public function schedule($s_id = NULL) {
        $row_s = $this->check_id_($s_id);
        $this->my_header_view_admin();
        $this->load->model('Schedule_Model');
        $this->load->view('admin/table', array(
            'caption' => 'Schedule of "' . $row_s->student_lastname . ', ' . $row_s->student_name . '." | ' . $row_s->student_school_id,
            'table' => $this->Schedule_Model->table_view_schedule($s_id),
            'href' => 'student/add-schedule/' . $s_id,
            'button_label' => 'Add schedule'
        ));
        $this->load->view('admin/footer2', array(
            'controller' => 'table'
        ));
    }

    private function form_add_sched($s_id) {
        $row_stud = $this->check_id_($s_id);
        $this->load->helper('form');
        $myform = array(
            'action' => 'student/add-schedule/' . $s_id,
            'button_name' => 'add_schedule_button',
            'button_label' => 'Add Schedule',
            'attr' => $this->my_input_addsched,
        );
        $this->load->view('admin/form', array(
            'myform' => $myform,
            'caption' => 'Add Schedule of student: "' . $row_stud->student_lastname . ', ' . $row_stud->student_name . '."'
        ));
    }

    public function add_schedule($s_id = NULL) {
        $this->check_id_($s_id);
        $this->my_header_view_admin();
        $this->load->library('form_validation');
        $this->validation_add_sched($s_id);
        $this->form_validation->set_error_delimiters('<span class="help-inline">', '</span>');

        $this->form_validation->set_rules($this->my_input_addsched);

        if (!$this->form_validation->run()) {
            $this->form_add_sched($s_id);
        } else {
            $data = array(
                'student_id' => $s_id,
                'schedule_id' => $this->input->post('schedule_id'),
                'admin_id' => $this->session->userdata('admin_id'),
            );
            $this->load->model('Student_Schedule_Model');
            $msg = ($this->Student_Schedule_Model->add($data)) ? 'Added!<br />' : 'Failed.<br />';
            $this->load->view('admin/msg', array(
                'msg' => $msg
            ));
        }


        $this->load->view('admin/footer2');
    }

    public function add() {

        $this->my_header_view_admin();

        $this->load->library('form_validation');
        $this->validation();
        $this->form_validation->set_error_delimiters('<span class="help-inline">', '</span>');

        $this->form_validation->set_rules($this->my_input);


        if (!$this->form_validation->run()) {
            $this->form();
        } else {

            $data = array(
                'student_name' => $this->input->post('firstname', TRUE),
                'student_lastname' => $this->input->post('lastname', TRUE),
                'student_school_id' => $this->input->post('school_id', TRUE),
                'student_course' => $this->input->post('course', TRUE),
                'student_pin' => password_hash($this->input->post('pin', TRUE), 1),
                'admin_id' => $this->session->userdata('admin_id'),
            );
            $this->load->model('Student_Model');
            $msg = ($this->Student_Model->add($data)) ? 'Student Added!' : 'Failed to add.';

            $this->load->view('admin/msg', array(
                'msg' => $msg
            ));
        }

        $this->load->view('admin/footer2');
    }

    private function check_id_($id = NULL) {
        if (is_null($id)) {
            show_404();
        }

        $this->load->model('Student_Model');
        $rs = $this->Student_Model->get(array(
            'student_id' => $id
        ));
        if (!$rs) {
            show_404();
        }
        return $rs->row();
    }

}
