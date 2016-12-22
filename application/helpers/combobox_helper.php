<?php

/**
 * 
 * 
 * @author Lloric Garcia <emorickfighter@gmail.com>
 * 
 */
defined('BASEPATH') or exit('no direct script allowed');

if (!function_exists('semester_for_combo')) {

    /**
     * 
     * @return array 1-1st Semester,2-2nd Semester,3-Summer Semester
     */
    function semester_for_combo() {
        return array(
            '1st' => '1st Semester',
            '2nd' => '2nd Semester',
            'Summer' => 'Summer Semester',
        );
    }

}

if (!function_exists('schoolyear_for_combo')) {

    /**
     * 
     * @return array 
     */
    function schoolyear_for_combo() {
        return array(
            '2016-2017' => '2016-2017',
            '2017-2018' => '2017-2018',
            '2018-2019' => '2018-2019',
            '2019-2020' => '2019-2020',
        );
    }

}

if (!function_exists('time_for_combo')) {

    /**
     * 
     * @return array key = 24hrs, value = 12hrs
     */
    function time_for_combo() {
        return array(
            '6:00' => '6:00 am',
            '7:00' => '7:00 am',
            '8:00' => '8:00 am',
            '9:00' => '9:00 am',
            '10:00' => '10:00 am',
            '11:00' => '11:00 am',
            '12:00' => '12:00 pm',
            '13:00' => '1:00 pm',
            '14:00' => '2:00 pm',
            '15:00' => '3:00 pm',
            '16:00' => '4:00 pm',
            '17:00' => '5:00 pm',
            '18:00' => '6:00 pm',
            '19:00' => '7:00 pm'
        );
    }

}

if (!function_exists('course_combo')) {

    function course_combo() {
        return array(
            'college' => 'College',
            'highshool' => 'High School',
            'elememtary' => 'Elementary',
        );
    }

}
if (!function_exists('my_lang_combo')) {

    function my_lang_combo() {
        return array(
            'english' => 'English',
            'filipino' => 'Filipino',
            'cebuano' => 'Cebuano',
        );
    }

}

if (!function_exists('drop_down_0_9')) {

    /**
     * 
     * @param int $s start
     * @param int $e end
     * @return array
     */
    function drop_down_0_9($s, $e) {
        $array = array();
        for ($i = $s; $i <= $e; $i++) {
            $array[$i] = $i;
        }
        return $array;
    }

}