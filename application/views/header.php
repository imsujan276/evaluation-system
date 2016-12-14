<?php
defined('BASEPATH') or exit('Direct Script is not all');
$title_header = 'Evaluation System';
$link = base_url('assets/libs/');
?>
<!DOCTYPE html>
<html>
    <title><?php echo $title_header; ?></title>
    <link href="<?php echo base_url('assets/img/favicon.ico'); ?>" rel="shortcut icon" type="image/x-icon" />
    <link rel="stylesheet" type="text/css" href="<?php echo $link; ?>style.css" />
    <body>
        <table width="64%" align="center" border="0" cellpadding="0" cellspacing="1" >
            <tr>
                <td height="60" colspan="2" align="center"> 
                    <p align="center"><b><font size="5"><?php echo anchor(base_url(), $title_header); ?></font></b></p>
                </td>
            </tr>
            <tr>
                <td height="60" colspan="2" align="center"> 
                    <p align="center"><font size="2"><?php
                        echo 'Branch: <b>' . ((is_null($row['branch'])) ? 'no data' : $row['branch']->branch_name ) . '</b> | ';
                        echo 'Batch: <b>' . ( (is_null($row['batch'])) ? 'no data' : $row['batch']->batch_name ) . '</b> | ';
                        echo 'Semester: <b>' . ( (is_null($row['semester'])) ? 'no data' : $row['semester']->semester_name ) . '</b> | ';
                        echo 'Division: <b>' . ((is_null($row['division'])) ? 'no data' : $row['division']->division_name) . '</b> ';
                        ?></font></p>
                </td>
            </tr>
            <tr>

                <td width="78%" valign="top">
                    <?php
                    echo '<p>Logged as: <b>' . $this->session->userdata('client_fullname') . '</b>.</p>';
                    echo '<p>Student School ID: <b>' . $this->session->userdata('client_school_id') . '</b>.</p>';
                    echo '<p>Student Course: <b>' . $this->session->userdata('client_course') . '</b>.</p>';
                    echo '<p>' . anchor(base_url('home/logout'), '<b>Logout</b>') . '</p>';



                    