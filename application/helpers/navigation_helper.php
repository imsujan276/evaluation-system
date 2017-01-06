<?php

defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('navigations_main')) {

    function navigations_main() {
        return array(
            'dashboard' =>
            array(
                'label' => 'Dashboard',
                'desc' => 'Dashboard Description',
                'icon' => 'dashboard',
            ),
            'parameter' =>
            array(
                'label' => lang('parameter_label'),
                'desc' => 'Dashboard Description',
                'icon' => 'bookmark',
            ),
            //sub menu
            'menus' =>
            array(
                'label' => lang('index_heading'),
                'icon' => 'user',
                'sub' =>
                array(
                    'users' =>
                    array(
                        'label' => lang('index_heading'),
                        'desc' => 'Users Description',
                        'seen' => TRUE,
                    ),
                    'create-user' =>
                    array(
                        'label' => lang('create_user_heading'),
                        'desc' => 'Create Users Description',
                        'seen' => TRUE,
                    ),
                    'edit-group' =>
                    array(
                        'label' => lang('edit_group_title'),
                        'desc' => 'Edit Group Description',
                        'seen' => FALSE,
                    ),
                    'deactivate' =>
                    array(
                        'label' => lang('deactivate_heading'),
                        'desc' => 'Deactivate User Description',
                        'seen' => FALSE,
                    ),
                    'edit-user' =>
                    array(
                        'label' => lang('edit_user_heading'),
                        'desc' => 'Edit User Description',
                        'seen' => FALSE,
                    ),
                ),
            ),
            //sub menu
            'menus4' =>
            array(
                'label' => lang('subject_label'),
                'icon' => 'book',
                'sub' =>
                array(
                    'subjects' =>
                    array(
                        'label' => lang('subject_label'),
                        'desc' => 'Language Description',
                        'seen' => TRUE,
                    ),
                    'create-subject' =>
                    array(
                        'label' => lang('subject_create_label'),
                        'desc' => 'Database Description',
                        'seen' => TRUE,
                    ),
                ),
            ),
            //sub menu
            'menus5' =>
            array(
                'label' => lang('question_label'),
                'icon' => 'question-sign',
                'sub' =>
                array(
                    'questions' =>
                    array(
                        'label' => lang('question_label'),
                        'desc' => 'Language Description',
                        'seen' => TRUE,
                    ),
                    'create-question' =>
                    array(
                        'label' => lang('create_question_label'),
                        'desc' => 'Database Description',
                        'seen' => TRUE,
                    ),
                ),
            ),
            'xxx' =>
            array(
                'label' => lang('feedback_label'),
                'desc' => 'Dashboard Description',
                'icon' => 'bullhorn',
                'sub' =>
                array(
                    'feedback' =>
                    array(
                        'label' => lang('feedback_label'),
                        'desc' => 'Chart Description',
                        'seen' => TRUE,
                    ),
                    'chart' =>
                    array(
                        'label' => 'Chart',
                        'desc' => 'Chart Description',
                        'seen' => FALSE,
                    ),
                ),
            ),
            //sub menu
            'menus6' =>
            array(
                'label' => 'Settings',
                'icon' => 'cogs',
                'sub' =>
                array(
//                    'language' =>
//                    array(
//                        'label' => lang('lang_label'),
//                        'desc' => 'Language Description',
//                        'seen' => TRUE,
//                    ),
                    'database' =>
                    array(
                        'label' => 'Database',
                        'desc' => 'Database Description',
                        'seen' => TRUE,
                    ),
                    'log' =>
                    array(
                        'label' => 'Error Logs',
                        'desc' => 'Error Logsn Description',
                        'seen' => TRUE,
                    ),
                ),
            ),
        );
    }

}

if (!function_exists('public_navigations_main')) {

    function public_navigations_main() {
        return array(
            'home' =>
            array(
                'label' => 'Home',
                'desc' => 'Dashboard Description',
                'icon' => 'home',
            ),
            //sub menu
            'menus5' =>
            array(
                'label' => lang('evaluate_label'),
                'icon' => 'legal',
                'sub' =>
                array(
                    'evaluate' =>
                    array(
                        'label' => lang('evaluate_label'),
                        'desc' => 'evaluate_label Description',
                        'seen' => FALSE,
                    ),
                ),
            ),
        );
    }

}


if (!function_exists('navigations_setting')) {

    function navigations_setting() {
        return array(
//            'language' =>
//            array(
//                'label' => lang('lang_label'),
//                'desc' => 'Language Description',
//                'icon' => 'comments-alt',
//            ),
            'database' =>
            array(
                'label' => 'Database',
                'desc' => 'Database Description',
                'icon' => 'hdd',
            ),
            'log' =>
            array(
                'label' => 'Error Logs',
                'desc' => 'Error Logsn Description',
                'icon' => 'exclamation-sign',
            ),
        );
    }

}

if (!function_exists('public_navigations_setting')) {

    function public_navigations_setting() {
        return array(
//            'language' =>
//            array(
//                'label' => lang('lang_label'),
//                'desc' => 'Language Description',
//                'icon' => 'comments-alt',
//            ),
        );
    }

}
