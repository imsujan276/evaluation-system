<?php

defined('BASEPATH') or exit('No direct script access allowed');

class User_Model extends MY_Model {

    public function __construct() {
        $this->table = 'users';
        $this->primary_key = 'id';
        //   $this->soft_deletes = true;
        //$this->has_one['details'] = 'User_details_model';
        // $this->has_one['details'] = array('User_details_model','user_id','id');
        //  $this->has_one['details'] = array('local_key' => 'id', 'foreign_key' => 'user_id', 'foreign_model' => 'User_details_model');
        // $this->has_many['posts'] = 'Post_model';

        parent::__construct();
    }

//    public function insert_($data_value) {
//        return $this->db->insert_batch($this->table, $data_value);
//    }
//
//    public function drop_down_faculty() {
//        $array = array();
//
//        $this->db->select("users.id,users.first_name,users.last_name");
//       
//        $this->db->join('subject', 'subject.user_id = users.id');
//        $this->db->join('users_groups', 'users_groups.user_id = users.id');
//        $this->db->join('groups', 'groups.id = users_groups.group_id');
//        $this->where('name', 'faculty');
//     //   $this->db->from('users as users');
//        $rs = $this->db->get('groups');
//         echo $this->db->last_query();
//        return $array;
//    }

}
