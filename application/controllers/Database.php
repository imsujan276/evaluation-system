<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Database extends Admin_Controller
{

        function __construct()
        {
                parent::__construct();
                $this->load->dbutil();
                $this->lang->load('ci_db');
        }

        public function index()
        {


                $heading    = array('Name', 'Type', 'max_length', 'primary_key');
                $data_table = array();
                foreach ($this->db->list_tables() as $db)
                {

                        $data_table[] = array(array('data' => '<h4>' . $db . '</h4>', 'colspan' => '4'));
                        foreach ($this->db->field_data($db) as $field)
                        {
                                $data_table[] = array($field->name, $field->type, $field->max_length, $field->primary_key);
                        }
                }

                $this->data['href']         = base_url('database/backup-database');
                $this->data['button_label'] = lang('db_back_up');
                $this->data['platform']     = $this->db->platform();
                $this->data['version']      = $this->db->version();
                $this->data['table']        = $this->table_view_pagination($heading, $data_table, 'table_open_bordered');
                $this->data['controller']   = 'table';



                $this->header_view();
                $this->_render_page('admin/button_view', $this->data);
                $this->_render_page('admin/database', $this->data);
                $this->_render_page('admin/footer', $this->data);
        }

        public function backup_database()
        {
                $this->load->helper('backup_database');
                backup_database('evaluation_system');
        }

}
