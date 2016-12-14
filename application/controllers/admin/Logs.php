<?php

defined('BASEPATH') or exit('Direct Script is not allowed');

class Logs extends MY_Controller {

    private $logPath; //path to the php log

    /**
     * 	Class constructor
     */

    function __construct() {
        parent::__construct();
        $this->logPath = ini_get('error_log');
    }

    /**
     * index: Shows the php error log
     * @access public
     */
    public function index() {
       $this->my_header_view_admin();

        //  echo nl2br(@file_get_contents($this->logPath));
        if (@is_file($this->logPath)) {
            $this->load->view('admin/msg', array(
                'msg' => '<p>add <b><code>/delete</code></b> in url to clear.</p><br />' . nl2br(@file_get_contents($this->logPath))
            ));
        } else {
            $this->load->view('admin/msg', array(
                'msg' => 'The log cannot be found in the specified route ' . $this->logPath
            ));
        }
        $this->load->view('admin/footer2');
        // exit;
    }

    /**
     * delete: Deletes the php error log
     * @access public
     */
    public function delete() {
        if (@is_file($this->logPath)) {
            if (@unlink($this->logPath)) {
                echo 'PHP Error Log deleted';
            } else {
                echo 'There has been an error trying to delete the PHP Error log ' . $this->logPath;
            }
        } else {
            echo 'The log cannot be found in the specified route  ' . $this->logPath . '.';
        }
        //   exit;
    }

}
