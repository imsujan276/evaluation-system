<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Parameter extends Admin_Controller
{

        function __construct()
        {
                parent::__construct();
                $this->load->helper('combobox');
                $this->load->model('Parameter_Model');
        }

        public function index()
        {
                $this->data['message'] = '';
                $this->form_validation->set_rules(array(
                    array(
                        'label' => lang('subject_semester'),
                        'field' => 'subject_semester',
                        'rules' => 'required'
                    ),
                    array(
                        'label' => lang('subject_year'),
                        'field' => 'subject_year',
                        'rules' => 'required'
                    ),
                    array(
                        'label' => lang('subject_course'),
                        'field' => 'subject_course',
                        'rules' => 'required'
                    ),
                ));

                if ($this->form_validation->run())
                {
                        $data_value = array(
                            'year'     => $this->input->post('subject_year'),
                            'course'   => $this->input->post('subject_course'),
                            'semester' => $this->input->post('subject_semester'),
                        );
                }
                if ($this->form_validation->run() and $this->Parameter_Model->update($data_value))
                {
                        $this->session->set_flashdata('message', lang('parameter_update_success'));
                }

                $this->data['parameter'] = $this->Parameter_Model->get();

                $this->data['message'] = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));

                $this->data['subject_year_combo']     = schoolyear_for_combo();
                $this->data['subject_year']           = array(
                    'name'  => 'subject_year',
                    'value' => $this->form_validation->set_value('subject_year'),
                );
                $this->data['subject_semester_combo'] = semester_for_combo();
                $this->data['subject_semester']       = array(
                    'name'  => 'subject_semester',
                    'value' => $this->form_validation->set_value('subject_semester'),
                );
                $this->data['subject_course_combo']   = course_combo();
                $this->data['subject_course']         = array(
                    'name'  => 'subject_course',
                    'value' => $this->form_validation->set_value('subject_course'),
                );

                $this->header_view();
                $this->_render_page('admin/parameter', $this->data);
                $this->_render_page('admin/footer', $this->data);
        }

}
