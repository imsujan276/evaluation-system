<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Create_subject extends Admin_Controller
{

        function __construct()
        {
                parent::__construct();
                $this->load->helper('combobox');
        }

        public function index()
        {
                $this->header_view();
                $this->data['message'] = '';
                $this->form_validation->set_rules(array(
                    array(
                        'label' => lang('subject_code'),
                        'field' => 'subject_code',
                        'rules' => 'required'
                    ),
                    array(
                        'label' => lang('subject_desc'),
                        'field' => 'subject_desc',
                        'rules' => 'required'
                    ),
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
                    array(
                        'label' => lang('subject_fuculty'),
                        'field' => 'faculty',
                        'rules' => 'required|numeric'
                    ),
                ));

                if ($this->form_validation->run())
                {
                        $this->load->model('Subject_Model');
                        $data_value = array(
                            array('subject_code'     => $this->input->post('subject_code'),
                                'subject_desc'     => $this->input->post('subject_desc'),
                                'subject_year'     => $this->input->post('subject_year'),
                                'subject_course'   => $this->input->post('subject_course'),
                                'subject_semester' => $this->input->post('subject_semester'),
                                'user_id'          => $this->input->post('faculty'),
                            )
                        );
                }

                if ($this->form_validation->run() and $this->Subject_Model->insert_($data_value))
                {
                        $this->session->set_flashdata('message', lang('subject_create_success'));
                        redirect(current_url(), 'refresh');
                }
                else
                {
                        $this->data['message']      = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
                        $this->data['subject_code'] = array(
                            'name'  => 'subject_code',
                            'id'    => 'subject_code',
                            'type'  => 'text',
                            'value' => $this->form_validation->set_value('subject_code'),
                        );

                        $this->data['subject_desc'] = array(
                            'name'  => 'subject_desc',
                            'id'    => 'subject_desc',
                            'type'  => 'text',
                            'value' => $this->form_validation->set_value('subject_desc'),
                        );

                        $this->data['subject_year']       = array(
                            'name'  => 'subject_year',
                            'value' => $this->form_validation->set_value('subject_year'),
                        );
                        $this->data['subject_year_combo'] = schoolyear_for_combo();

                        $this->data['subject_semester']       = array(
                            'name'  => 'subject_semester',
                            'value' => $this->form_validation->set_value('subject_semester'),
                        );
                        $this->data['subject_semester_combo'] = semester_for_combo();

                        $this->data['subject_course']       = array(
                            'name'  => 'subject_course',
                            'value' => $this->form_validation->set_value('subject_course'),
                        );
                        $this->data['subject_course_combo'] = course_combo();

                        //get all user has faculty grooup
                        $this->data['faculty']       = array(
                            'name'  => 'faculty',
                            'value' => $this->form_validation->set_value('faculty'),
                        );
                        $this->data['faculty_combo'] = $this->faculties();

                        $this->_render_page('admin/create_subject', $this->data);
                }



                $this->_render_page('admin/footer', $this->data);
        }

        private function faculties()
        {
                $array     = array();
                $users_obj = $this->ion_auth->users()->result();
                foreach ($users_obj as $k => $user)
                {
                        $groups_bj = $this->ion_auth->get_users_groups($user->id)->result();
                        if ($groups_bj)
                        {
                                foreach ($groups_bj as $groups_bj)
                                {
                                        if ($groups_bj->name === 'faculty')
                                        {
                                                $array[$user->id] = $user->last_name . ', ' . $user->first_name;
                                        }
                                }
                        }
                }
                return $array;
        }

}
