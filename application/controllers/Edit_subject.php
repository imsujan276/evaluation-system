<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Edit_subject extends Admin_Controller
{

        function __construct()
        {
                parent::__construct();
                $this->load->helper('combobox');
                $this->load->model(array('User_Model', 'Subject_Model'));
        }

        public function index()
        {
                $subject_id = NULL;
                if (!$subject_id = $this->input->get('subject-id'))
                {
                        show_error('Missing parameter');
                }
                $subject_obj = $this->Subject_Model->get($subject_id);
                if (!$subject_obj)
                {
                        show_error('Invalid request.');
                }

                $this->data['subject_id'] = $subject_id;

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
                $run__                 = $this->form_validation->run();
                if ($run__)
                {
                        $data_value = array(
                            'subject_code'     => $this->input->post('subject_code'),
                            'subject_desc'     => $this->input->post('subject_desc'),
                            'subject_year'     => $this->input->post('subject_year'),
                            'subject_course'   => $this->input->post('subject_course'),
                            'subject_semester' => $this->input->post('subject_semester'),
                            'user_id'          => $this->input->post('faculty')
                        );
                }

                if ($run__ and $this->Subject_Model->update($data_value, $subject_id))
                {
                        $this->session->set_flashdata('message', lang('subject_update_success'));
                        redirect(base_url("edit-subject/?subject-id=" . $subject_id), 'refresh');
                }
                else
                {
                        $this->data['message']      = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
                        $this->data['subject_code'] = array(
                            'name'  => 'subject_code',
                            'id'    => 'subject_code',
                            'type'  => 'text',
                            'value' => $this->set_value__(
                                    $subject_obj->subject_code, 'subject_code'
                            ),
                        );

                        /////////////////////////////////////////////////////

                        $this->data['subject_desc'] = array(
                            'name'  => 'subject_desc',
                            'id'    => 'subject_desc',
                            'type'  => 'text',
                            'value' => $this->set_value__(
                                    $subject_obj->subject_desc, 'subject_desc'
                            ),
                        );

                        //////////////////////////////////////////

                        $this->data['subject_year']       = array(
                            'name' => 'subject_year',
                        );
                        $this->data['subject_year_combo'] = schoolyear_for_combo();
                        $this->data['subject_year_value'] = $this->set_value__(
                                $subject_obj->subject_year, 'subject_year'
                        );

                        /////////////////////////////////////////


                        $this->data['subject_semester']       = array(
                            'name' => 'subject_semester',
                        );
                        $this->data['subject_semester_combo'] = semester_for_combo();
                        $this->data['subject_semester_value'] = $this->set_value__(
                                $subject_obj->subject_semester, 'subject_semester'
                        );

                        //////////////////////////////////////////////


                        $this->data['subject_course']       = array(
                            'name' => 'subject_course',
                        );
                        $this->data['subject_course_combo'] = course_combo();
                        $this->data['subject_course_value'] = $this->set_value__(
                                $subject_obj->subject_course, 'subject_course'
                        );

                        ///////////////////////////////////////////////////////////
                        //get all user has faculty grooup
                        $this->data['faculty']       = array(
                            'name' => 'faculty',
                        );
                        $this->data['faculty_value'] = $this->set_value__(
                                $this->ion_auth->user($subject_obj->user_id)->row()->id, 'faculty'
                        );
                        $this->data['faculty_combo'] = $this->User_Model->faculties();
                        //   $this->data['faculty_value'] = $subject_obj->user_id;
                        $this->_render_page('admin/edit_subject', $this->data);
                }



                $this->_render_page('admin/footer', $this->data);
        }

        /**
         * 
         * @param string $db_val
         * @param string $post_val
         * @return string
         */
        private function set_value__($db_val, $post_val)
        {
                $value__ = $this->form_validation->set_value($post_val);
                if ($value__ != NULL)
                {
                        log_message('debug', $post_val . '111111<<<<<<<<<<<<' . $value__ . '>');
                        return $value__;
                }
                else
                {
                        log_message('debug', $post_val . '2222222222<<<<<<<<<<<<' . $db_val . ']');
                        return $db_val;
                }
        }

}
