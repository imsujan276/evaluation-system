<?php defined('BASEPATH') OR exit('No direct script allowed'); ?>
<?php echo form_open(current_url()); ?>

<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12"> 
            <?php echo validation_errors(); ?> 
        </div>
    </div>
</div>
<div class="container-fluid">
    <hr>
    <div class="row-fluid">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                    <h5><?php echo $caption; ?></h5>
                </div>
                <div class="widget-content nopadding">
                    <?php echo $table_data; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12"> 
            <?php
            echo form_textarea($remark, set_value('remark'));
            ?> 
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12"> 
            <?php
            echo form_submit('submit', lang('evaluation_submit_button'), array(
                'class' => 'btn btn-success'
            ));
            ?> 
        </div>
    </div>
</div>
<?php echo form_close(); ?>