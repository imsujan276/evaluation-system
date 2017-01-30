<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Edit_question extends Admin_Controller
{

        function __construct()
        {
                parent::__construct();
                $this->load->helper('combobox');
                $this->load->model(array('User_Model', 'Question_Model'));
        }

        public function index()
        {
                $question_id = NULL;
                if (!$question_id = $this->input->get('question-id'))
                {
                        show_error('Missing parameter');
                }
                $question_obj = $this->Question_Model->get($question_id);
                if (!$question_obj)
                {
                        show_error('Invalid request.');
                }

                $this->data['question_id'] = $question_id;

                $this->data['message'] = '';
                $this->form_validation->set_rules(array(
                    array(
                        'field' => 'question_key',
                        'label' => lang('question_key_label'),
                        'rules' => 'required'
                    ),
                    array(
                        'field' => 'question_value',
                        'label' => lang('question_value_label'),
                        'rules' => 'required'
                    ),
                ));
                $run                   = $this->form_validation->run();

                if ($run)
                {
                        $data__ = array(
                            'question_key'   => $this->input->post('question_key'),
                            'question_value' => $this->input->post('question_value')
                        );
                }

                if ($run and $this->Question_Model->update($data__, $question_id))
                {
                        $this->session->set_flashdata('message', lang('question_update_success'));
                      //  redirect(base_url("edit-question/?question-id=" . $question_id), 'refresh');
                }
                $this->data['message']        = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
                $this->data['question_key']   = array(
                    'name'  => 'question_key',
                    'value' => $this->set_value__(
                            $question_obj->question_key, 'question_key'
                    )
                );
                $this->data['question_value'] = array(
                    'name'  => 'question_value',
                    'value' => $this->set_value__(
                            $question_obj->question_value, 'question_value'
                    ),
                    'type'  => 'textarea',
                );


                $this->header_view();
                $this->_render_page('admin/update_question', $this->data);
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
