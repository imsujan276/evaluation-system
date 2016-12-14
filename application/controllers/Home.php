<?php

defined('BASEPATH') or exit('Direct Script is not allowed');

class Home extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $row = $this->my_header_client();
        $this->load->view('myview', array(
            'msg' => '<br /><h4>Select faculty to evaluate from current BRANCH. (according to your subject schedule.)</h4>' . $this->faculty($row),
        ));
        $this->load->view('admin/footer');
    }

    private function faculty($row) {
        // $this->load->helper('form');

        $this->load->model('Faculty_Model');
        $html = '';
        if ($row['branch']) {
            $rs = $this->Faculty_Model->get(array('branch_id' => $row['branch']->branch_id));

            if ($rs) {
                $tmp = 1;
                foreach ($rs->result() as $row) {
                    $html .= '<p>' . anchor('faculty/index/' . $row->faculty_id, $tmp++ . '. ' . $row->faculty_school_id . ' | ' . $row->faculty_lastname . ', ' . $row->faculty_name) . '</p>';
                }
            }
            if ($html == '') {
                $html = 'No faculty from branch <b>' . $row['branch']->branch_name . '</b>.';
            }
        }
        if ($html == '') {
            $html = 'no data to retrive.';
        }
        return $html . '<br /><br />';
    }

    public function logout() {
        $this->session->unset_userdata('logged_in');
        session_destroy();
        redirect(base_url('login'), 'refresh');
    }

}
