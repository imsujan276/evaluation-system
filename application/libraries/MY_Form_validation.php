<?php

defined('BASEPATH') or exit('Direct Script is not allowed');

class MY_Form_validation extends CI_Form_validation {

    const human_name_regex = '/^[a-zA-Z. ]*$/';
    const school_id_regex = '/^[A-Z]{1}\d{7}$/';

    public function numeric_0_to_9($value) {
        $this->CI->form_validation->set_message('numeric_0_to_9', 'Please select score in Key <b>{field}</b>.');
        if ($value >= 0 && $value <= 9) {
            return TRUE;
        } else if ($value < 0 || $value > 9) {
            $this->CI->form_validation->set_message('numeric_0_to_9', 'Invalid score in Key <b>{field}</b>.');
            return FALSE;
        }
        return FALSE;
    }

    public function human_name($value) {
        $this->CI->form_validation->set_message('human_name', 'Invalid <b>{field}</b> format.');
        if (preg_match(MY_Form_validation::human_name_regex, $value)) {
            return TRUE;
        }
        return FALSE;
    }

    public function school_id($value) {
        $this->CI->form_validation->set_message('school_id', 'Invalid <b>{field}</b> format. must be [C]-[7digit]');
        if (preg_match(MY_Form_validation::school_id_regex, $value)) {
            return TRUE;
        }
        return FALSE;
    }

}
