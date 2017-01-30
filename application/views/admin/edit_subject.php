<?php
defined('BASEPATH') or exit('Direct Script is not allowed');
?>
<div class="container-fluid">
    <hr>
    <div class="row-fluid">
        <div class="span12">

            <div class="widget-box">
                <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                    <h5><?php echo lang('subject_edit') ?></h5>
                </div>
                <div class="widget-content nopadding">
                    <?php
//echo validation_errors();
                    echo $message;

                    echo form_open(base_url("edit-subject/?subject-id=" . $subject_id), array(
                        'class'      => 'form-horizontal',
                        'name'       => 'basic_validate',
                        'id'         => 'basic_validate',
                        'novalidate' => 'novalidate',
                    ));



                    //subject code:
                    $tmp = (form_error('subject_code') == '') ? '' : ' error';
                    echo '<div class="control-group' . $tmp . '">';
                    echo lang('subject_code', 'subject_code', array(
                        'class' => 'control-label',
                        'id'    => 'inputError'
                    ));
                    echo '<div class="controls">';
                    echo form_input($subject_code, array(
                        'id' => 'inputError'
                    ));
                    echo form_error('subject_code');
                    echo '</div></div> ';



                    //subject desc
                    $tmp = (form_error('subject_desc') == '') ? '' : ' error';
                    echo '<div class="control-group' . $tmp . '">';
                    echo lang('subject_desc', 'subject_desc', array(
                        'class' => 'control-label',
                        'id'    => 'inputError'
                    ));
                    echo '<div class="controls">';
                    echo form_input($subject_desc, array(
                        'id' => 'inputError'
                    ));
                    echo form_error('subject_desc');
                    echo '</div></div> ';




                    //subject year:
                    $tmp = (form_error('subject_year') == '') ? '' : ' error';
                    echo '<div class="control-group' . $tmp . '">';
                    echo lang('subject_year', 'subject_year', array(
                        'class' => 'control-label',
                        'id'    => 'inputError'
                    ));
                    echo '<div class="controls">';
                    echo form_dropdown($subject_year, $subject_year_combo, $subject_year_value);
                    echo form_error('subject_year');
                    echo '</div></div> ';



                    //semester:
                    $tmp = (form_error('subject_semester') == '') ? '' : ' error';
                    echo '<div class="control-group' . $tmp . '">';
                    echo lang('subject_semester', 'subject_semester', array(
                        'class' => 'control-label',
                        'id'    => 'inputError'
                    ));
                    echo '<div class="controls">';
                    echo form_dropdown($subject_semester, $subject_semester_combo, $subject_semester_value);
                    echo form_error('subject_semester');
                    echo '</div></div> ';



                    //course:
                    $tmp = (form_error('subject_course') == '') ? '' : ' error';
                    echo '<div class="control-group' . $tmp . '">';
                    echo lang('subject_course', 'subject_course', array(
                        'class' => 'control-label',
                        'id'    => 'inputError'
                    ));
                    echo '<div class="controls">';
                    echo form_dropdown($subject_course, $subject_course_combo, $subject_course_value);
                    echo form_error('subject_course');
                    echo '</div></div> ';


                    //faculty:
                    $tmp = (form_error('faculty') == '') ? '' : ' error';
                    echo '<div class="control-group' . $tmp . '">';
                    echo lang('subject_fuculty', 'faculty', array(
                        'class' => 'control-label',
                        'id'    => 'inputError'
                    ));
                    echo '<div class="controls">';
//                    echo form_input($faculty, array(
//                        'id' => 'inputError'
//                    ));
                    echo form_dropdown($faculty, $faculty_combo, $faculty_value);
                    echo form_error('faculty');
                    echo '</div></div> ';




                    echo ' <div class="form-actions">';

                    echo form_submit('submit', lang('subject_create_btn'), array(
                        'class' => 'btn btn-success'
                    ));

                    echo form_reset('reset', 'Reset', array(
                        'class' => 'btn btn-default'
                    ));

                    echo '</div>';
                    echo form_close();
                    ?>

                </div>
            </div>
        </div>
    </div>
</div>

