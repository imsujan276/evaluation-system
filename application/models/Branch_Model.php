<?php

defined('BASEPATH') or exit('no direct script allowed');

class Branch_Model extends MY_Model {

    const db_table = 'branch';

    function __construct() {
        parent::__construct();
    }

    public function table_view() {
        $data = array();
        $branchs_rs = $this->my_select(self::db_table);
        if ($branchs_rs) {
            foreach ($branchs_rs->result() as $branch) {
                array_push($data, array(
                    'id' => $branch->branch_id,
                    'name' => $branch->branch_name,
                    'option' => anchor(base_url('admin/branch#'), 'update', array('class' => 'btn btn-success btn-mini')) . ' | '
                    . anchor(base_url('admin/branch#'), 'delete', array('class' => 'btn btn-success btn-mini')),
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

    public function get($column = NULL) {
        return $this->my_select(self::db_table, $column);
    }

    public function add($values) {
        return $this->my_insert(self::db_table, $values);
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
                $data[$row->branch_id] = $row->branch_name;
            }
        }
        return $data;
    }

    public function update($s, $w = NULL) {
        return $this->my_update(self::db_table, $s, $w);
    }

}
