<?php

defined('BASEPATH') or exit('no direct script allowed');

class Batch_Model extends MY_Model {

    const db_table = 'batch';

    public function __construct() {
        parent::__construct();
    }

    public function table_view() {
        $data = array();
        $batchs_rs = $this->my_select(self::db_table);
        if ($batchs_rs) {
            foreach ($batchs_rs->result() as $batch) {
                array_push($data, array(
                    'id' => $batch->batch_id,
                    'name' => $batch->batch_name,
                    'option' => anchor(base_url('admin/batch#'), 'update', array('class' => 'btn btn-success btn-mini')) . ' | '
                    . anchor(base_url('admin/batch#'), 'delete', array('class' => 'btn btn-success btn-mini')),
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

    /**
     * for combo
     * @return array
     */
    public function combo() {
        $data = array();
        $rs = $this->my_select(self::db_table);
        if ($rs) {
            foreach ($rs->result() as $row) {
                $data[$row->batch_id] = $row->batch_name;
            }
        }
        return $data;
    }

    public function get($column = NULL) {
        return $this->my_select(self::db_table, $column);
    }

    public function update($s, $w = NULL) {
        return $this->my_update(self::db_table, $s, $w);
    }

}
