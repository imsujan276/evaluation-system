<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Feedback extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('User_Model', 'Subject_Model', 'Remark_Model'));
    }

    private function _data_($semester, $year, $course) {
        $parameters = array(
            'subject_semester' => $semester,
            'subject_year' => $year,
            'subject_course' => $course,
        );
        $subject_obj = $this->Subject_Model->where($parameters)->get_all();
        $headings = array(lang('subject_code'), lang('subject_desc'), lang('subject_fuculty'), lang('feedback_label'), lang('evaluate_status_header'));

        $data_table = array();
        if ($subject_obj) {
            foreach ($subject_obj as $k => $v) {

                $user_obj = $this->User_Model->where(array('id' => $v->user_id))->get();

//                $span = 'done';
//                $status = 'done evaluate.';
//                $link = '<i class="icon-ok-sign"></i> ' . $user_obj->last_name . ', ' . $user_obj->first_name;
//                $btn = '----';
                //     if (!$this->done($user_obj->id, $v->subject_id)) {
                if (1) {
                    $span = 'in-progress';
                    $status = 'not evaluated yet.';
                    $link = '<i class="icon-plus-sign"></i> ' . $user_obj->last_name . ', ' . $user_obj->first_name;

                    $btn = anchor(base_url('feedback/result/' . $v->subject_id), lang('feedback_label'), array('class' => 'btn btn-success btn-mini'));
                }


                array_push($data_table, array(
                    $v->subject_code,
                    $v->subject_desc,
                    /* '<span class="by label">' . */ $link /* . '</span>' */,
                    $btn,
                    array(
                        'data' => '<span class="' . $span . '">' . $status . '</span>',
                        'class' => 'taskStatus'
                    )
                ));
            }
        }
        return array(
            'headings' => $headings,
            'data_table' => $data_table
        );
    }

    public function index() {

        $this->load->helper('combobox');
        $this->data['controller'] = 'table';
        $this->data['subject_year_combo'] = schoolyear_for_combo();
        $this->data['subject_year'] = array(
            'name' => 'subject_year',
                //  'value' => $this->form_validation->set_value('subject_year'),
        );
        $this->data['subject_semester_combo'] = semester_for_combo();
        $this->data['subject_semester'] = array(
            'name' => 'subject_semester',
                // 'value' => $this->form_validation->set_value('subject_semester'),
        );
        $this->data['subject_course_combo'] = course_combo();
        $this->data['subject_course'] = array(
            'name' => 'subject_course',
                // 'value' => $this->form_validation->set_value('subject_course'),
        );

        $redi = FALSE;
        if (!is_null($this->input->get('subject_year')) and ! is_null($this->input->get('subject_semester')) and ! is_null($this->input->get('subject_course'))) {

            $semester = $this->input->get('subject_semester');
            $year = $this->input->get('subject_year');
            $course = $this->input->get('subject_course');

            $tmp = $this->_data_($semester, $year, $course);

            $this->data['caption'] = lang('subject_label');
            $this->data['table_data'] = $this->table_view_pagination($tmp['headings'], $tmp['data_table'], 'table_open_pagination');
            $redi = TRUE;
        }



        $this->header_view();
        $this->_render_page('admin/parameter_feedback', $this->data);

        if ($redi) {
            // $this->_render_page('admin/feedback_subjects', $this->data);
            $this->_render_page('admin/table', $this->data);
        }

        $this->_render_page('admin/footer', $this->data);
    }

    private function students() {
        $array = array();
        $users_obj = $this->ion_auth->users()->result();
        foreach ($users_obj as $k => $user) {
            $groups_bj = $this->ion_auth->get_users_groups($user->id)->result();
            if ($groups_bj) {
                foreach ($groups_bj as $groups_bj) {
                    if ($groups_bj->name === 'student') {
                        $array[$user->id] = $user->last_name . ', ' . $user->first_name;
                    }
                }
            }
        }
        return $array;
    }

    public function result($subject_id = NULL) {
        $this->load->model(array('Question_Model', 'Parameter_Model', 'Score_Model'));

        $subject_obj = $this->Subject_Model->where(array('subject_id' => $subject_id))->get();
        $user_array = $this->students();
        if (!$subject_obj) {
            show_error(lang('subject_error'));
        }

        $question_obj = $this->Question_Model->get_all();

        $question_keys = array();

        // setting up the heading for table
        if ($question_obj) {
            foreach ($question_obj as $k => $v) {
                $question_keys[] = $v->question_key;
            }
        }

        # key- question key | value - total of score in qiestion
        # I initialize here to not include 'remark'
        $score_summary = $question_keys;

        //add one header fro remarks
        $question_keys['remark'] = 'Remarks';

        $scores = array();
        //getting the score individuals
        if ($question_obj) {
            //student
            foreach ($user_array as $id => $uv) {
                $tmp = array();
                $has_ = TRUE;
                //question
                foreach ($question_obj as $qk => $qv) {

                    //score
                    $score_obj = $this->Score_Model->where(array(
                                'question_id' => $qv->question_id,
                                'subject_id' => $subject_obj->subject_id,
                                'student_id' => $id
                            ))->get();
                    if ($score_obj) {
                        $tmp[] = $score_obj->score_value;

                        #key | add score (append)
                        $score_summary[$qk] += $score_obj->score_value;
                    } else {
                        $has_ = FALSE;
                        continue;
                        //  $tmp[]='xx';
                    }
                }

                //finally add remark value in every row
                $tmp[] = $this->Remark_Model->where(array(
                            'subject_id' => $subject_obj->subject_id,
                            'student_id' => $id
                        ))->get()->remark_value;

                if (!$has_) {
                    continue;
                }
                $scores[] = $tmp;
            }
            //echo print_r($score_summary);
        }



        $this->data['caption'] = lang('score_label');
        $this->data['table_data'] = $this->table_view_pagination($question_keys, $scores, 'table_open_pagination');
        $this->data['controller'] = 'table';
        $this->data['parameter'] = $this->Parameter_Model->get_parameter($subject_obj);
        $this->data['faculty'] = $this->User_Model->where(array('id' => $subject_obj->user_id))->get();
        $this->data['subject'] = $subject_obj;
        //remove
        unset($question_keys['remark']);
        $this->data['table_data_summary'] = $this->table_view_pagination($question_keys, array($score_summary), 'table_open_invoice');


        $this->header_view();
        $this->_render_page('parameter_info', $this->data);
        $this->_render_page('admin/table', $this->data);
        $this->_render_page('admin/result_summary.php', $this->data);
        //   $this->_render_page('admin/chart', $this->data);
        $this->_render_page('admin/footer', $this->data);
    }

}
