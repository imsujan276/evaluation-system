<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Public_Controller
{


        /**
         *
         * @var array
         */
        private $parameters = array();

        function __construct()
        {
                parent::__construct();
                $this->load->model(array('Subject_Model', 'Parameter_Model', 'User_Model', 'Remark_Model'));
                $parameter_obj = $this->Parameter_Model->get();
                if ($parameter_obj)
                {
                        $this->parameters = array(
                            'subject_semester' => $parameter_obj->semester,
                            'subject_year'     => $parameter_obj->year,
                            'subject_course'   => $parameter_obj->course,
                        );
                }
        }

        private function done($user_id, $subject_id)
        {
                $remark_obj = $this->Remark_Model->where(array(
                            'faculty_id' => $user_id,
                            'student_id' => $this->session->userdata('user_id'),
                            'subject_id' => $subject_id,
                        ))->get();
                if ($remark_obj)
                {
                        return TRUE;
                }
                return FALSE;
        }

        public function index()
        {// done in-progress |span class
                $this->data['test'] = '';

                $subject_obj = $this->Subject_Model->where($this->parameters)->get_all();
                //   $subject_obj = $this->Subject_Model->with_authors('fields:first_name')->where($this->parameters)->get_all();
                //  echo $this->db->last_query();
                $headings    = array(lang('subject_code'), lang('subject_desc'), lang('subject_fuculty'), lang('evaluate_label'), lang('evaluate_status_header'));

                $data_table = array();
                if ($subject_obj)
                {
                        foreach ($subject_obj as $k => $v)
                        {

                                $user_obj = $this->User_Model->where(array('id' => $v->user_id))->get();

                                $span   = 'done';
                                $status = 'done evaluate.';
                                $link   = '<i class="icon-ok-sign"></i> ' . $user_obj->last_name . ', ' . $user_obj->first_name;
                                $btn    = '----';
                                if (!$this->done($user_obj->id, $v->subject_id))
                                {
                                        $span   = 'in-progress';
                                        $status = 'not evaluated yet.';
                                        $link   = '<i class="icon-plus-sign"></i> ' . $user_obj->last_name . ', ' . $user_obj->first_name;

                                        $btn = anchor(base_url('evaluate/index/' . $v->subject_id), lang('evaluate_label'), array('class' => 'btn btn-success btn-mini'));
                                }


                                array_push($data_table, array(
                                    $v->subject_code,
                                    $v->subject_desc,
                                    /* '<span class="by label">' . */ $link /* . '</span>' */,
                                    $btn,
                                    array(
                                        'data'  => '<span class="' . $span . '">' . $status . '</span>',
                                        'class' => 'taskStatus'
                                    )
                                ));
                        }
                }
                $this->data['table_data'] = $this->table_view_pagination($headings, $data_table, 'table_open_pagination');
                $this->data['caption']    = lang('subject_label');
                $this->data['controller'] = 'table';
                $this->data['parameter']  = $this->Parameter_Model->get();


                $this->header_view();
                $this->_render_page('home_parameter_info', $this->data);
                $this->_render_page('admin/table', $this->data);
                $this->_render_page('admin/footer', $this->data);
        }

}
