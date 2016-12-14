<?php

defined('BASEPATH') or exit('no direct script allowed');

class Question_Model extends MY_Model {

    const db_table = 'question';

    function __construct() {
        parent::__construct();
    }

    public function table_view() {
        $data = array();
        $rs = $this->my_select(self::db_table);
        if ($rs) {
            $this->load->model('Category_Model');
            foreach ($rs->result() as $row) {
                $row_c = $this->Category_Model->get(array('category_id' => $row->category_id))->row();
                array_push($data, array(
                    'id' => $row->question_id,
                    'question' => $row->question_long,
                    'key' => $row->question_short,
                    'category' => $row_c->category_name,
                    'option' => anchor(base_url('admin/question#'), 'update', array('class' => 'btn btn-success btn-mini')) . ' | '
                    . anchor(base_url('admin/question#'), 'delete', array('class' => 'btn btn-success btn-mini')),
                ));
            }
        }
        $header = array(
            'id' => 'ID',
            'question' => 'Question',
            'key' => 'Key',
            'category' => 'Category',
            'option' => 'Option',
        );
        return $this->my_table_view($header, $data);
    }

    public function add($values) {
        return $this->my_insert(self::db_table, $values);
    }

    public function update($s, $w = NULL) {
        return $this->my_update(self::db_table, $s, $w);
    }

    public function get($column = NULL) {
        return $this->my_select(self::db_table, $column);
    }

}
