<?php
defined('BASEPATH') or exit('Direct Script is not all');
$title_header = 'Evaluation System | Admin Panel';
$link = base_url('assets/libs/');
$nav = array(
    'home' => 'Home',
    'batch' => 'Batch',
    'branch' => 'Branch',
    'semester' => 'Semester',
    'division' => 'Division',
    'subject' => 'Subject',
    'student' => 'Student',
    'faculty' => 'Faculty',
    'category' => 'Feedback Category',
    'question' => 'Feedback Ques',
    'parameter' => 'Set Parameter',
    'feedback' => 'Feedback',
    'backup' => 'Backup Database',
    'password' => 'Change Password',
    'logs' => 'Error Logs',
    'home/logout' => 'Log out',
);

$title = 'Home';
$current = $this->uri->segment(2);

foreach ($nav as $k => $value) {
    if ($current == '') {
        break;
    } else if ($current == $k) {
        $title = $value;
        break;
    }
}
?>
<!DOCTYPE html>
<html>
    <title><?php echo $title ?> | Admin</title>
    <link href="<?php echo base_url('assets/img/favicon.ico'); ?>" rel="shortcut icon" type="image/x-icon" />
    <link rel="stylesheet" type="text/css" href="<?php echo $link; ?>style.css" />
    <body>
        <table width="64%" align="center" border="0" cellpadding="0" cellspacing="1" >
            <tr>
                <td height="60" colspan="2" align="center"> 
                    <p align="center"><b><font size="5"><?php echo anchor(base_url('admin'), $title_header); ?></font></b></p>
                </td>
            </tr>
            <tr>
                <td width="22%">
                    <table id="one-column-emphasis" align="left" style="vertical-align:top" border="0" cellpadding="1" cellspacing="0">
                        <?php foreach ($nav as $k => $v): ?>
                            <?php $active = ($current == $k) ? ' style="background-color: #b3b3f0"' : ''; ?>
                            <tr><td<?php echo $active; ?>><a href="<?php echo base_url('admin/' . $k); ?>"><?php echo $v; ?></a></td></tr>
                        <?php endforeach; ?>
                    </table>
                </td>

                <td width="78%" valign="top">

                    <h1><a href="<?php echo base_url('admin/' . $current) ?>"><?php echo $title; ?></a></h1>
