<?php
defined('BASEPATH') or exit('Direct Script is not allowed');
?>


<div class="container-fluid"><hr>
    <div class="row-fluid">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"> <i class="icon-briefcase"></i> </span>
                    <h5>Evaluation System</h5>
                </div>
                <div class="widget-content">
                    <div class="row-fluid">
                        <div class="span6">
                            <table class="">
                                <tbody>
                                    <tr>
                                        <td><h4>Evaluation System</h4></td>
                                    </tr>
                                    <tr>
                                        <td>Your Town</td>
                                    </tr>
                                    <tr>
                                        <td>Your Region/State</td>
                                    </tr>
                                    <tr>
                                        <td>Mobile Phone: +4530422244</td>
                                    </tr>
                                    <tr>
                                        <td >me@company.com</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="span6">
                            <table class="table table-bordered table-invoice">
                                <tbody>
                                    <tr>
                                    <tr>
                                        <td>Year</td>
                                        <td><strong><?php echo $parameter->year ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td>Semester</td>
                                        <td><strong><?php echo $parameter->semester ?></strong></td>
                                    </tr>

                                    <tr>
                                        <td class="width30">Course</td>
                                        <td class="width70"><strong><?php echo $parameter->course ?></strong></td>
                                    </tr>
                                </tbody>

                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">

            <div class="widget-box">
                <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                    <h5><?php echo lang('parameter_label') ?></h5>
                </div>

                <div class="widget-content nopadding">

                    <?php
//echo validation_errors();
                    echo $message;

                    echo form_open(base_url("parameter/index"), array(
                        'class' => 'form-horizontal',
                        'name' => 'basic_validate',
                        'id' => 'basic_validate',
                        'novalidate' => 'novalidate',
                    ));





                    //subject year:
                    $tmp = (form_error('subject_year') == '') ? '' : ' error';
                    echo '<div class="control-group' . $tmp . '">';
                    echo lang('subject_year', 'subject_year', array(
                        'class' => 'control-label',
                        'id' => 'inputError'
                    ));
                    echo '<div class="controls">';
                    echo form_dropdown($subject_year, $subject_year_combo);
                    echo form_error('subject_year');
                    echo '</div></div> ';



                    //semester:
                    $tmp = (form_error('subject_semester') == '') ? '' : ' error';
                    echo '<div class="control-group' . $tmp . '">';
                    echo lang('subject_semester', 'subject_semester', array(
                        'class' => 'control-label',
                        'id' => 'inputError'
                    ));
                    echo '<div class="controls">';
                    echo form_dropdown($subject_semester, $subject_semester_combo);
                    echo form_error('subject_semester');
                    echo '</div></div> ';



                    //course:
                    $tmp = (form_error('subject_course') == '') ? '' : ' error';
                    echo '<div class="control-group' . $tmp . '">';
                    echo lang('subject_course', 'subject_course', array(
                        'class' => 'control-label',
                        'id' => 'inputError'
                    ));
                    echo '<div class="controls">';
                    echo form_dropdown($subject_course, $subject_course_combo);
                    echo form_error('subject_course');
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

