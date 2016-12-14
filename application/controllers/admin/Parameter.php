<?php

defined('BASEPATH') or exit('Direct Script is not allowed');

class Parameter extends MY_Controller {

    private $my_input;

    public function __construct() {
        parent::__construct();

        $this->load->model(array('Semester_Model', 'Batch_Model', 'Division_Model', 'Branch_Model'));
    }

    public function index() {
        $this->my_header_view_admin();


        $this->load->view('admin/msg', array(
            'msg' => $this->generate_view(),
        ));
        $this->form_process();

        $this->load->view('admin/footer2');
    }

    private function form_process() {
        $this->load->library('form_validation');
        $this->validation();
        $this->form_validation->set_error_delimiters('<span class="help-inline">', '</span>');
        $this->form_validation->set_rules($this->my_input);
        if (!$this->form_validation->run()) {
            $this->form();
        } else {
            $this->set_inactive_all();
            $s = $this->input->post('semester_id');
            $d = $this->input->post('division_id');
            $br = $this->input->post('branch_id');
            $ba = $this->input->post('batch_id');

            $this->Semester_Model->update(array('semester_active' => TRUE), array('semester_id' => $s));
            $this->Batch_Model->update(array('batch_active' => TRUE), array('batch_id' => $ba));
            $this->Division_Model->update(array('division_active' => TRUE), array('division_id' => $d));
            $this->Branch_Model->update(array('branch_active' => TRUE), array('branch_id' => $br));

            $this->load->view('admin/msg', array(
                'msg' => 'Done!'
            ));
        }
    }

    private function set_inactive_all() {
        $this->Semester_Model->update(array('semester_active' => FALSE));
        $this->Batch_Model->update(array('batch_active' => FALSE));
        $this->Division_Model->update(array('division_active' => FALSE));
        $this->Branch_Model->update(array('branch_active' => FALSE));
    }

    private function generate_view() {
        $rows = array(
            'semester' => $this->Semester_Model->get(array('semester_active' => TRUE)),
            'batch' => $this->Batch_Model->get(array('batch_active' => TRUE)),
            'division' => $this->Division_Model->get(array('division_active' => TRUE)),
            'branch' => $this->Branch_Model->get(array('branch_active' => TRUE)),
        );
        $fields = array(
            array(
                'value' => ($rows['semester']) ? $rows['semester']->row()->semester_name : 'no active',
                'label' => 'Semester',
            ),
            array(
                'value' => ($rows['batch']) ? $rows['batch']->row()->batch_name : 'no active',
                'label' => 'Batch',
            ),
            array(
                'value' => ($rows['division']) ? $rows['division']->row()->division_name : 'no active',
                'label' => 'Division',
            ),
            array(
                'value' => ($rows['branch']) ? $rows['branch']->row()->branch_name : 'no active',
                'label' => 'Branch',
            ),
        );


        $html = '';
        foreach ($fields as $v) {
            $html .= '<p>' . $v['label'] . ': <b>' . $v['value'] . '</b></p>';
        }


        return $html;
    }

    private function validation() {

        $this->my_input = array(
            array(
                'field' => 'branch_id',
                'label' => 'Branch',
                'rules' => 'required|numeric',
                'type' => 'combo',
                'combo_value' => $this->Branch_Model->combo(),
            ),
            array(
                'field' => 'semester_id',
                'label' => 'Semester',
                'rules' => 'required|numeric',
                'type' => 'combo',
                'combo_value' => $this->Semester_Model->combo(),
            ),
            array(
                'field' => 'batch_id',
                'label' => 'Batch',
                'rules' => 'required|numeric',
                'type' => 'combo',
                'combo_value' => $this->Batch_Model->combo(),
            ),
            array(
                'field' => 'division_id',
                'label' => 'Division',
                'rules' => 'required|numeric',
                'type' => 'combo',
                'combo_value' => $this->Division_Model->combo(),
            ),
        );
    }

    private function form() {

        $this->load->helper('form');
        $myform = array(
            'action' => 'parameter',
            'button_name' => 'update_parameter_button',
            'button_label' => 'Update Parameter',
            'attr' => $this->my_input,
        );
        $this->load->view('admin/form', array(
            'myform' => $myform,
            'caption' => 'Parameter'
        ));
    }

}
