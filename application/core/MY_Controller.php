<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->validate_session();
    }

    private function validate_session() {
        $this->load->model('Session_Model');
        $this->Session_Model->my_check_session();

    }

    public function my_navigations() {
        return array(
            'home' =>
            array(
                'label' => 'Home',
                'desc' => 'Home Description',
                'icon' => 'home',
            ),
            'parameter' =>
            array(
                'label' => 'Parameter',
                'desc' => 'Parameter Description',
                'icon' => 'wrench',
            ),
            //sub menu
            'menus1' =>
            array(
                'label' => 'Manage Area',
                'icon' => 'pushpin',
                'count' => '4',
                'sub' =>
                array(
                    'batch' =>
                    array(
                        'label' => 'Batch',
                        'desc' => 'Batch Description',
                    ),
                    'branch' =>
                    array(
                        'label' => 'Branch',
                        'desc' => 'Branch Description',
                    ),
                    'semester' =>
                    array(
                        'label' => 'Semester',
                        'desc' => 'Semester Description',
                    ),
                    'division' =>
                    array(
                        'label' => 'Division',
                        'desc' => 'Division Description',
                    ),
                ),
            ), //sub menu
            'menus2' =>
            array(
                'label' => 'Users / Subjects',
                'icon' => 'group',
                'count' => '3',
                'sub' =>
                array(
                    'subject' =>
                    array(
                        'label' => 'Subject',
                        'desc' => 'Subject Description',
                    ),
                    'student' =>
                    array(
                        'label' => 'Student',
                        'desc' => 'Student Description',
                    ),
                    'faculty' =>
                    array(
                        'label' => 'Faculty',
                        'desc' => 'Faculty Description',
                    ),
                ),
            ), //sub menu
            'menus3' =>
            array(
                'label' => 'Feedback',
                'icon' => 'th-list',
                'count' => '3',
                'sub' =>
                array(
                    'category' =>
                    array(
                        'label' => 'Feedback Category',
                        'desc' => 'Feedback Category Description',
                    ),
                    'question' =>
                    array(
                        'label' => 'Feedback Question',
                        'desc' => 'Feedback Question Description',
                    ),
                    'feedback' =>
                    array(
                        'label' => 'Feedback',
                        'desc' => 'Feedback Description',
                    ),
                ),
            ), //sub menu
            'menus4' =>
            array(
                'label' => 'Settings',
                'icon' => 'cogs',
                'count' => '3',
                'sub' =>
                array(
                    'backup' =>
                    array(
                        'label' => 'Backup Database',
                        'desc' => 'Backup Database Description',
                    ),
                    'password' =>
                    array(
                        'label' => 'Change Password',
                        'desc' => 'Change Passwor Description',
                    ),
                    'logs' =>
                    array(
                        'label' => 'Error Logs',
                        'desc' => 'Error Logsn Description',
                    ),
                ),
            ),
        );
    }

    private function setting_navs() {
        return array(
            'backup' =>
            array(
                'label' => 'Backup Database',
                'desc' => 'Backup Database Description',
                'icon' => 'file',
            ),
            'password' =>
            array(
                'label' => 'Change Password',
                'desc' => 'Change Passwor Description',
                'icon' => 'eye-close',
            ),
            'logs' =>
            array(
                'label' => 'Error Logs',
                'desc' => 'Error Logsn Description',
                'icon' => 'exclamation-sign',
            ),
        );
    }

    public function my_header_view_admin() {
        $this->load->view('admin/header2', array(
            'navigations' => $this->my_navigations(),
            'setting_vavigations' => $this->setting_navs()
        ));
    }

    public function my_header_client() {
        $models = array(
            'semester' => array(
                'model' => 'Semester_Model',
                'id' => 'semester_id',
                'act' => 'semester_active',
            ),
            'batch' => array(
                'model' => 'Batch_Model',
                'id' => 'batch_id',
                'act' => 'batch_active',
            ),
            'branch' => array(
                'model' => 'Branch_Model',
                'id' => 'branch_id',
                'act' => 'branch_active',
            ),
            'division' => array(
                'model' => 'Division_Model',
                'id' => 'division_id',
                'act' => 'division_active',
            ),
        );

        $rows = array();
        foreach ($models as $k => $v) {
            //load models
            $this->load->model($v['model']);
            //initialize rows
            //prevent null
            $rs = $this->$v['model']->get(array($v['act'] => TRUE));

            if ($rs) {
                $rows[$k] = $rs->row();
            } else {
                $rows[$k] = NULL;
            }
        }
        $this->load->view('header', array(
            'row' => $rows,
        ));
        return $rows;
    }

}
