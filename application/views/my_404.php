<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$link = base_url('assets/framework/bootstrap/admin/');
$title_header = '404 | Evaluation System';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $title_header; ?></title>
        <link href="<?php echo base_url('assets/img/favicon.ico'); ?>" rel="shortcut icon" type="image/x-icon" />
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="<?php echo $link; ?>css/bootstrap.min.css" />
        <link rel="stylesheet" href="<?php echo $link; ?>css/bootstrap-responsive.min.css" />
        <link rel="stylesheet" href="<?php echo $link; ?>css/matrix-style.css" />
        <link rel="stylesheet" href="<?php echo $link; ?>css/matrix-media.css" />
        <link href="<?php echo $link; ?>font-awesome/css/font-awesome.css" rel="stylesheet" />
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
    </head>
    <body>
        <div class="error_ex">
            <h1>404</h1>
            <h3>Opps, You're lost.</h3>
            <p>We can not find the page you're looking for.</p>
<!--                <a class="btn btn-warning btn-big"  href="<?php //echo $link; ?>index.html">Back to Home</a> -->
        </div>
    </body>
</html>
