<?php
defined('BASEPATH') or exit('Direct Script is not all');
?>


<div class="container-fluid">
    <hr>
    <div class="row-fluid">
        <div class="span12">
            <?php echo (!is_null($href)) ? anchor(base_url('admin/' . $href), $button_label, array('class' => 'btn btn-info')) : ''; ?>
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                    <h5><?php echo $caption; ?></h5>
                </div>
                <div class="widget-content nopadding">
                    <?php echo $table; ?>
                </div>
            </div>
        </div>
    </div>
</div>