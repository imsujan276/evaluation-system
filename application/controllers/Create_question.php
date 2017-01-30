<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Create_question extends Admin_Controller
{

        function __construct()
        {
                parent::__construct();
                $this->load->model('Question_Model');
        }

        public function index()
        {

                $this->data['message']    = '';
                $this->data['controller'] = 'table';
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

                $run = $this->form_validation->run();

                if ($run)
                {
                        $data__ = array(
                            'key'   => $this->input->post('question_key'),
                            'value' => $this->input->post('question_value'),
                        );
                }

                if ($run and $this->Question_Model->add($data__))
                {
                        $this->session->set_flashdata('message', lang('question_create_success'));
                        redirect(current_url(), 'refresh');
                }
                $this->data['message']        = (validation_errors() ? validation_errors() : $this->session->flashdata('message'));
                $this->data['question_key']   = array(
                    'name'  => 'question_key',
                    'value' => $this->form_validation->set_value('question_key'),
                );
                $this->data['question_value'] = array(
                    'name'  => 'question_value',
                    'value' => $this->form_validation->set_value('question_value'),
                    'type'  => 'textarea',
                );


                $this->header_view();
                $this->_render_page('admin/create_question', $this->data);
                $this->_render_page('admin/footer', $this->data);
        }

}
