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
                                        <td><h4><?php echo $faculty->last_name . ', ' . $faculty->first_name ?></h4></td>
                                    </tr>
                                    <tr>
                                        <td>Subject Code: <b><?php echo $subject->subject_code; ?></b></td>
                                    </tr>
                                    <tr>
                                        <td>Subject Description: <b><?php echo $subject->subject_desc; ?></b></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="span6">
                            <table class="table table-bordered table-invoice">
                                <tbody>
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
