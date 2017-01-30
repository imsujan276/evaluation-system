<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Log extends Admin_Controller
{

        function __construct()
        {
                parent::__construct();

                $this->load->model('Log_Model');

                $this->config->load('log');
        }

        public function index()
        {

                //store colum nnames of logs table
                $heading = array();
                foreach ($this->db->field_data($this->config->item('log_table_name')) as $field)
                {
                        $heading[] = $field->name;
                }
                //set ass header table
                //get data from database table logs
                $logs = $this->Log_Model->get_all();

                $data_table_array = array();
                //if has value
                if ($logs)
                {
                        foreach ($logs as $k => $v)
                        {
                                $tmp = array();
                                //loop every clomn names
                                foreach ($heading as $kk => $vv)
                                {
                                        $tmp[$kk] = $v->$vv;
                                }
                                // $this->table->add_row($tmp);
                                array_push($data_table_array, $tmp);
                        }
                }
                $this->data['table_data'] = $this->table_view_pagination($heading, $data_table_array, 'table_open_pagination');
                $this->data['caption']    = 'Error Logs';
                $this->data['controller'] = 'table';


                $this->header_view();
                $this->_render_page('admin/table', $this->data);
                $this->_render_page('admin/footer', $this->data);
        }

}
