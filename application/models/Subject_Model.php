<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Subject_Model extends MY_Model
{

        public function __construct()
        {
                $this->table       = 'subject';
                $this->primary_key = 'subject_id';
                //   $this->soft_deletes = true;
                //$this->has_one['details'] = 'User_details_model';
                // $this->has_one['details'] = array('User_details_model','user_id','id');
                //  $this->has_one['details'] = array('local_key' => 'id', 'foreign_key' => 'user_id', 'foreign_model' => 'User_details_model');
                // $this->has_many['posts'] = 'Post_model';
//        
//        $this->has_one['user'] = array(
//            'foreign_model' => 'User_Model',
//            'foreign_table' => 'users',
//            'foreign_key' => 'user_id',
//            'local_key' => 'id'
//        );
//
//  $this->has_many_pivot['authors'] = array(
//            'foreign_model'=>'User_model',
//            'pivot_table'=>'articles_users',
//            'local_key'=>'id',
//            'pivot_local_key'=>'article_id',
//            'pivot_foreign_key'=>'user_id',
//            'foreign_key'=>'id');

                parent::__construct();
        }

}
