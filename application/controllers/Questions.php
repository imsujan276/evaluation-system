<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Questions extends Admin_Controller
{

        function __construct()
        {
                parent::__construct();

                $this->load->model('Question_Model');
        }

        public function index()
        {

                $question_obj = $this->Question_Model->get_all();
                $data_table   = array();
                if ($question_obj)
                {
                        $inc = 1;
                        foreach ($question_obj as $question)
                        {
                                array_push($data_table, array(
                                    $inc++, $question->question_key, $question->question_value,
                                    anchor(base_url('edit-question/?question-id=' . $question->question_id), lang('question_edit'))
                                ));
                        }
                }

                $headings                 = array(
                    '#', lang('question_key_label'), lang('question_value_label'), lang('question_table_option')
                );
                $this->data['table_data'] = $this->table_view_pagination($headings, $data_table, 'table_open_pagination');
                $this->data['caption']    = lang('question_label');
                $this->data['controller'] = 'table';


                $this->header_view();
                $this->_render_page('admin/button_view', array(
                    'href'         => 'create-question',
                    'button_label' => lang('create_question_label'),
                ));
                $this->_render_page('admin/table', $this->data);
                $this->_render_page('admin/footer', $this->data);
        }

}
