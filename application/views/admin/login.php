<?php
defined('BASEPATH') or exit('Direct Script is not all');
$title_header = 'Evaluation System | Admin Panel';
$link = base_url('assets/libs/');
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
        <link href="<?php echo base_url('assets/img/favicon.ico'); ?>" rel="shortcut icon" type="image/x-icon" />
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <link rel="stylesheet" type="text/css" href="<?php echo $link; ?>style.css" />
    </head>

    <body>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <table width="500" border="0" align="center">
            <tr>
                <td>

                    <?php echo form_open(base_url('admin/login/validate'), array('name' => 'form1')) ?>

                    <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
                        <tr>
                            <td colspan="3" align="center"><font size="5" ><strong><?php echo $title_header; ?></strong></font></td>
                        </tr>
                        <tr>

                            <?php
                            echo (!is_null($msg)) ? '<div class="form-group">' . $msg . '</div>' : '';
                            ?>
                        </tr>
                        <tr><td colspan="3">&nbsp;</td></tr>
                        <tr>
                            <td width="205" ><div align="right">Username</div></td>
                            <td width="3"><div align="center">:</div></td>
                            <td width="268">
                                <div align="left">
                                    <?php
                                    echo form_input(array(
                                        'name' => 'username',
                                        'value' => set_value('username'),
                                        'placeholder' => "Username",
                                        'id' => 'myusername'
                                    ));
                                    ?>
                                </div></td>
                        </tr>
                        <tr>
                            <td><div align="right">Password</div></td>
                            <td><div align="center">:</div></td>
                            <td>
                                <div align="left">
                                    <?php
                                    echo form_password(array(
                                        'name' => 'password',
                                        'placeholder' => "Password",
                                        'id' => 'mypassword'
                                    ));
                                    ?>
                                </div></td>
                        </tr>
                        <tr>
                            <td><div align="right"></div></td>
                            <td><div align="center"></div></td>
                            <td>
                                <div align="left">
                                    <?php
                                    echo form_submit('submit', 'Login', array(
                                        'class' => 'button'
                                    ));
                                    ?>
                                </div></td>
                        </tr>
                    </table>
                    <?php echo form_close() ?>

                </td>
            </tr>
            <tr><td><table width="100%">
                        <tr>
                            <td align="left" valign="top">&nbsp;</td>
                            <td align="right"><font face="Times New Roman, Times, serif" size="-1" ></font></td>
                        </tr>
                    </table></td></tr></table>
    </body>
</html>
