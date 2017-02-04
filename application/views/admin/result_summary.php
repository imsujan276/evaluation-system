<?php
defined('BASEPATH') or exit('Direct Script is not allowed');
?>


<div class="container-fluid"><hr>
    <div class="row-fluid">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"> <i class="icon-briefcase"></i> </span>
                    <h5>Result Summary (Average)</h5>
                </div>
                <div class="widget-content">
                    <div class="row-fluid">
                        <div class="span6">
                            <?php echo $table_data_summary; ?>
                        </div>
                    </div>

                </div>
                <div class="widget-content">
                    <div class="row-fluid">
                        <div class="span12">
                            <h1><b>Average: </b>  <?php echo $ave__; ?></h1>
                            <h1><b>Percent: </b>  <?php echo $per__; ?>%</h1>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
