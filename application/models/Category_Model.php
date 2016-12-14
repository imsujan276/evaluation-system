<?php

defined('BASEPATH') or exit('no direct script allowed');

class Category_Model extends MY_Model {

    const db_table = 'category';

    function __construct() {
        parent::__construct();
    }

    public function table_view() {
        $data = array();
        $rs = $this->my_select(self::db_table);
        if ($rs) {
            foreach ($rs->result() as $row) {
                array_push($data, array(
                    'id' => $row->category_id,
                    'name' => $row->category_name,
                    'option' => anchor(base_url('admin/category#'), 'update', array('class' => 'btn btn-success btn-mini')) . ' | '
                    . anchor(base_url('admin/category#'), 'delete', array('class' => 'btn btn-success btn-mini')),
                ));
            }
        }
        $header = array(
            'id' => 'ID',
            'name' => 'Name',
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

    /**
     * for combo
     * @return array
     */
    public function combo() {
        $data = array();
        $rs = $this->my_select(self::db_table);
        if ($rs) {
            foreach ($rs->result() as $row) {
                $data[$row->category_id] = $row->category_name;
            }
        }
        return $data;
    }

    public function get($column = NULL) {
        return $this->my_select(self::db_table, $column);
    }

}
