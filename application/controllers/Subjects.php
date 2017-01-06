<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Subjects extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('Subject_Model', 'User_Model'));
    }

    public function index() {
        $this->data['test'] = '';

        $headings = array(
            lang('subject_desc'), lang('subject_code'), lang('subject_year'), lang('subject_semester'), lang('subject_course'), lang('subject_fuculty'), lang('subject_table_option')
        );


        $subject_obj = $this->Subject_Model->get_all();
        $data_table = array();
        if ($subject_obj) {
            foreach ($subject_obj as $subject) {
                $user_obj = $this->User_Model->where('id', $subject->user_id)->get();
                $fullname = $user_obj->last_name . ', ' . $user_obj->first_name;
                array_push($data_table, array(
                    $subject->subject_desc, $subject->subject_code, $subject->subject_year, $subject->subject_semester, $subject->subject_course, $fullname, anchor(base_url('subjects/#' . $subject->subject_id), lang('subject_edit'))
                ));
            }
        }
        $this->data['caption'] = lang('subject_label');
        $this->data['table_data'] = $this->table_view_pagination($headings, $data_table, 'table_open_pagination');
        $this->data['controller'] = 'table';


        $this->header_view();
        $this->_render_page('admin/button_view', array(
            'href' => 'create-subject',
            'button_label' => lang('subject_create_label'),
        ));
        $this->_render_page('admin/table', $this->data);
        $this->_render_page('admin/footer', $this->data);
    }

}
