<?php
defined('BASEPATH') or exit('Direct Script is not allowed');
?>
<div class="container-fluid">
    <hr>
    <div class="row-fluid">
        <div class="span12">

            <div class="widget-box">
                <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                    <h5><?php echo lang('create_question_label') ?></h5>
                </div>
                <div class="widget-content nopadding">
                    <?php
//echo validation_errors();
                    echo $message;

                    echo form_open(base_url("create-question/index"), array(
                        'class'      => 'form-horizontal',
                        'name'       => 'basic_validate',
                        'id'         => 'basic_validate',
                        'novalidate' => 'novalidate',
                    ));



                    //key
                    $tmp = (form_error('question_key') == '') ? '' : ' error';
                    echo '<div class="control-group' . $tmp . '">';
                    echo lang('question_key_label', 'question_key', array(
                        'class' => 'control-label',
                        'id'    => 'inputError'
                    ));
                    echo '<div class="controls">';
                    echo form_input($question_key, array(
                        'id' => 'inputError'
                    ));
                    echo form_error('question_key');
                    echo '</div></div> ';



                    //question_value:
                    $tmp = (form_error('question_value') == '') ? '' : ' error';
                    echo '<div class="control-group' . $tmp . '">';
                    echo lang('question_value_label', 'question_value', array(
                        'class' => 'control-label',
                        'id'    => 'inputError'
                    ));
                    echo '<div class="controls">';
                    echo form_textarea($question_value, array(
                        'id' => 'inputError'
                    ));
                    echo form_error('question_value');
                    echo '</div></div> ';






                    echo ' <div class="form-actions">';

                    echo form_submit('submit', lang('create_question_submit_btn'), array(
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

