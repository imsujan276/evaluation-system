<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Question_Model extends MY_Model {

    public function __construct() {
        $this->table = 'question';
        $this->primary_key = 'question_id';
        //   $this->soft_deletes = true;
        //$this->has_one['details'] = 'User_details_model';
        // $this->has_one['details'] = array('User_details_model','user_id','id');
        //  $this->has_one['details'] = array('local_key' => 'id', 'foreign_key' => 'user_id', 'foreign_model' => 'User_details_model');
        // $this->has_many['posts'] = 'Post_model';

        parent::__construct();
    }

    /**
     * 
     * @param array $data
     * @return bool FALSE on failure
     */
    public function add($data) {
        $insert_data = array(
            array(
                'question_key' => $data['key'],
                'question_value' => $data['value'],
            ),
        );
        return (bool) $this->db->insert_batch($this->table, $insert_data);
    }

}
