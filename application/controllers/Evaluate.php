<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Evaluate extends Public_Controller
{

        function __construct()
        {
                parent::__construct();
                $this->load->model(array('Subject_Model', 'Parameter_Model', 'User_Model', 'Question_Model', 'Remark_Model'));
                $this->load->helper('combobox');
        }

        private function validate($subject_id = NULL)
        {
                $subject_obj = $this->Subject_Model->where(array('subject_id' => $subject_id))->get();
                if (!$subject_obj)
                {
                        show_error(lang('subject_error'));
                }

                //check parameter
                $parameter_obj = $this->Parameter_Model->get();
                if ($parameter_obj->semester != $subject_obj->subject_semester or
                        $parameter_obj->year != $subject_obj->subject_year or
                        $parameter_obj->course != $subject_obj->subject_course)
                {
                        show_error(lang('subject_error'));
                }

                //check if done evaluate by current user
                $remark_obj = $this->Remark_Model->where(array(
                            'faculty_id' => $subject_obj->user_id,
                            'student_id' => $this->session->userdata('user_id'),
                            'subject_id' => $subject_obj->subject_id,
                        ))->get();
                if ($remark_obj)
                {
                        show_error(lang('already_evaluated'));
                }

                return $subject_obj;
        }

        private function create_validation_rules($question_obj)
        {
                $validation_rules = array();
                foreach ($question_obj as $k => $v)
                {
                        $validation_rules[] = array(
                            'field' => $v->question_key,
                            'label' => $v->question_key,
                            'rules' => 'required|is_natural|numeric_0_to_9'
                        );
                }
                $validation_rules[] = array(
                    'field' => 'remark',
                    'label' => 'Remark',
                    'rules' => 'required|min_length[10]'
                );
                $this->form_validation->set_rules($validation_rules);
        }

        public function index($subject_id = NULL)
        {
                #
                # validate the id 
                #
        $subject_obj = $this->validate($subject_id);
                $user_obj    = $this->User_Model->where(array('id' => $subject_obj->user_id))->get();

                $heading    = array(lang('evaluation_key_question'), lang('evaluation_value_question'), lang('evaluation_score'));
                $table_data = array();

                $question_obj = $this->Question_Model->get_all();
                $this->create_validation_rules($question_obj);
                if ($question_obj)
                {
                        foreach ($question_obj as $k => $v)
                        {
                                $table_data[] = array($v->question_key, $v->question_value, form_dropdown($v->question_key, drop_down_0_9(0, 4)));
                        }
                }

                $this->data['table_data'] = $this->table_view_pagination($heading, $table_data, 'table_open_bordered');
                $this->data['parameter']  = $this->Parameter_Model->get();
                $this->data['faculty']    = $user_obj;
                $this->data['subject']    = $subject_obj;
                $this->data['controller'] = 'table';
                $this->data['caption']    = 'Evaluation Form | Excellent - 4 / Average - 3 / Below Average -2 / Needs Improvement -1';
                $this->data['remark']     = array(
                    'name'        => 'remark',
                    'cols'        => '600',
                    'placeholder' => 'Remark'
                );

                $run = $this->form_validation->run();

                $scores = array();
                $remark = array();
                if ($run)
                {
                        foreach ($question_obj as $k => $v)
                        {
                                $scores[] = array(
                                    'faculty_id'  => $user_obj->id,
                                    'student_id'  => $this->session->userdata('user_id'),
                                    'subject_id'  => $subject_obj->subject_id,
                                    'score_value' => $this->input->post($v->question_key),
                                    'question_id' => $v->question_id
                                );
                        }
                        $remark[] = array(
                            'faculty_id'   => $user_obj->id,
                            'student_id'   => $this->session->userdata('user_id'),
                            'subject_id'   => $subject_obj->subject_id,
                            'remark_value' => $this->input->post('remark'),
                        );
                        $this->load->model('Score_Model');
                }




                //rendering page


                $this->header_view();
                $this->_render_page('parameter_info', $this->data);

                if ($run and $this->Score_Model->add($scores) and $this->Remark_Model->add($remark))
                {
                        //success!
                        $this->_render_page('done', $this->data);
                }
                else
                {
                        $this->_render_page('evaluate_form', $this->data);
                }
                $this->_render_page('admin/footer', $this->data);
        }

}
