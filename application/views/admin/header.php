<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 *
 * MY CONSTANT
 * 
 */
const TITLETAB = 'Evaluation System';
const TITLE1 = 'Evaluation';
const TITLE2 = 'System';
const SEGMENT_NUMBER = 1; //base_url 0,
const MENU_ITEM_DEFAULT = 'dashboard';
const BOOTSTRAPS_LIB_DIR = 'assets/framework/bootstrap/admin/';
const HOME_REDIRECT = ''; // sample    admin/

$main_sub = '';
/**
 * navigation
 */
$menu_items = $navigations;

$menu_settings = $setting_vavigations;

$active_link = TRUE;
// Determine the current menu item.
$menu_current = MENU_ITEM_DEFAULT;
//-------------------------------------
if ($this->uri->segment(1) == '')//if no controller in request, so i do this to prevent error
    $menu_current = 'home';
//----------------------------------------
// If there is a query for a specific menu item and that menu item exists...
if (@array_key_exists($this->uri->segment(SEGMENT_NUMBER), $menu_items)) {
    $menu_current = $this->uri->segment(SEGMENT_NUMBER);
}
if (MENU_ITEM_DEFAULT == $menu_current) {
    foreach ($menu_items as $key => $item) {
        if (isset($item['sub'])) {
            if (@array_key_exists($this->uri->segment(SEGMENT_NUMBER), $item['sub'])) {

                $main_sub = $key;
                $menu_current = $this->uri->segment(SEGMENT_NUMBER);


                foreach ($item['sub'] as $k => $v) {
                    if ($menu_current == $k) {
                        $active_link = $v['seen'];
                    }
                }
                break;
            }
        }
    }
}

$label = html_escape(((isset($menu_items[$menu_current]['label'])) ? $menu_items[$menu_current]['label'] : $menu_items[$main_sub]['label']));
$sub_label = html_escape(((isset($menu_items[$menu_current]['label'])) ? '' : $menu_items[$main_sub]['sub'][$this->uri->segment(SEGMENT_NUMBER)]['label']));
?><!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo ($sub_label != '') ? $sub_label : $label; ?> | <?php echo TITLETAB; ?></title>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href="<?php echo base_url(); ?>assets/img/favicon.ico" rel="shortcut icon" type="image/x-icon" />
        <link rel="stylesheet" href="<?php echo base_url(BOOTSTRAPS_LIB_DIR); ?>css/bootstrap.min.css" />
        <link rel="stylesheet" href="<?php echo base_url(BOOTSTRAPS_LIB_DIR); ?>css/bootstrap-responsive.min.css" />
        <link rel="stylesheet" href="<?php echo base_url(BOOTSTRAPS_LIB_DIR); ?>css/fullcalendar.css" />
        <link rel="stylesheet" href="<?php echo base_url(BOOTSTRAPS_LIB_DIR); ?>css/matrix-style.css" />
        <link rel="stylesheet" href="<?php echo base_url(BOOTSTRAPS_LIB_DIR); ?>css/matrix-media.css" />
        <link href="<?php echo base_url(BOOTSTRAPS_LIB_DIR); ?>font-awesome/css/font-awesome.css" rel="stylesheet" />
        <link rel="stylesheet" href="<?php echo base_url(BOOTSTRAPS_LIB_DIR); ?>css/jquery.gritter.css" />
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>


        <link rel="stylesheet" href="<?php echo base_url(BOOTSTRAPS_LIB_DIR); ?>css/jquery.gritter.css" />

        <link rel="stylesheet" href="<?php echo base_url(BOOTSTRAPS_LIB_DIR); ?>css/uniform.css" />
        <link rel="stylesheet" href="<?php echo base_url(BOOTSTRAPS_LIB_DIR); ?>css/select2.css" />


    </head>
    <body>

        <!--Header-part-->
        <div id="header">
            <h1><a href="dashboard.html"><?php echo TITLETAB; ?></a></h1>
        </div>
        <!--close-Header-part--> 


        <!--top-Header-menu-->
        <div id="user-nav" class="navbar navbar-inverse">
            <ul class="nav">
                <li  class="dropdown" id="profile-messages" ><a title="" href="#" data-toggle="dropdown" data-target="#profile-messages" class="dropdown-toggle"><i class="icon icon-user"></i>  <span class="text"><?php echo $this->session->userdata('user_last_name') . ', ' . $this->session->userdata('user_first_name'); ?></span><b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo base_url('auth/logout'); ?>"><i class="icon-key"></i> Log Out</a></li>
                    </ul>
                </li>
                <li class="dropdown" id="menu-messages">
                    <a href="#" data-toggle="dropdown" data-target="#menu-messages" class="dropdown-toggle">
                        <i class="icon icon-cog"></i> 
                        <span class="text">Settings</span> 
<!--                        <span class="label label-important">5</span> -->
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <?php foreach ($menu_settings as $k => $v): ?>  
                            <li class="divider"></li>
                            <li><a class="sAdd" title="" href="<?php echo base_url($k); ?>"><i class="icon-<?php echo $v['icon']; ?>"></i> <?php echo $v['label']; ?></a></li>

                        <?php endforeach; ?>
                    </ul>
                </li>
                <li class="">
                    <a title="" href="<?php echo base_url('auth/logout'); ?>">
                        <i class="icon icon-share-alt"></i> 
                        <span class="text">Logout</span>
                    </a>
                </li>
                <li class="">
                    <a title="">
                        <i class="icon icon-bolt"></i> 
                        <span class="text">
                            {elapsed_time} 
                        </span> 
                        <i class="icon icon-leaf"></i> 
                        <span class="text">
                            {memory_usage}
                        </span>
                        <i class="icon icon-beaker"></i> 
                        <span class="text">
                            <?php echo CI_VERSION; ?>
                        </span>
                    </a>
                </li>
                <?php if (ENVIRONMENT === 'development'): ?>
                    <li class="">
                        <a title="">
                            <i class="icon icon-magic"></i> 
                            <span class="text">
                                Developing Mode 
                            </span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
        <!--close-top-Header-menu-->
        <!--start-top-serch-->
        <div id="search">
            <input type="text" placeholder="Search here..."/>
            <button type="submit" class="tip-bottom" title="Search"><i class="icon-search icon-white"></i></button>
        </div>
        <!--close-top-serch-->
        <!--sidebar-menu-->
        <div id="sidebar"><a href="#" class="visible-phone"><i class="icon icon-home"></i> Dashboard</a>
            <ul>
                <?php
                /**
                 * navigations
                 */
                foreach ($menu_items as $key => $item) {
                    if (isset($item['sub'])) {
                        //sub menu
                        $active1 = ($key == $main_sub ? ' active' : '');

                        $count = 0;
                        foreach ($item['sub'] as $value) {
                            if ($value['seen']) {
                                $count++;
                            }
                        }
                        echo '<li class="submenu' . $active1 . '">'
                        . '<a href="#"><i class="icon icon-' . $item['icon'] . '"></i>'
                        . '<span>' . $item['label'] . '</span> ';
                        //--------------------------
                        if ($count > 0) {
                            echo'<span class="label label-important">' . $count . '</span>';
                        }
                        //---------------------------
                        echo '</a>'
                        . '<ul>';
                        foreach ($item['sub'] as $sub_key => $sub_item) {
                            if ($sub_item['seen']) {
                                echo '<li><a href="' . base_url(HOME_REDIRECT . $sub_key) . '">' . $sub_item['label'] . '</a></li>';
                            }
                        }
                        echo '</ul>'
                        . '</li>';
                    } else {
                        $active = ($key == $menu_current ? ' class="active"' : '');

                        echo '<li' . $active . '>'
                        . '<a href="' . base_url(HOME_REDIRECT . $key) . '">'
                        . '<i class="icon icon-' . $item['icon'] . '"></i>'
                        . '<span>' . $item['label'] . '</span>'
                        . '</a>'
                        . '</li>';
                    }
                }
                ?>
            </ul>
        </div>
        <!--sidebar-menu-->

        <!--main-container-part-->
        <div id="content">
            <!--breadcrumbs-->
            <div id="content-header">
                <div id="breadcrumb"> 
                    <a href="<?php echo base_url(); ?>" title="Go to Home" class="tip-bottom">
                        <i class="icon-home"></i> Home
                    </a> 
                    <?php
                    echo '<a' .
                    (



                    //-----------------start
                    #if
                    ($sub_label != '') ?
                            #then
                            '' :
                            #else

                            ' href="' . base_url(HOME_REDIRECT . $menu_current) . '"'


                    //--------------end


                    )
                    .
                    (
                    //--------------start
                    #if
                    ($sub_label != '') ?
                            #then
                            '' :
                            #else
                            ' class="current"'

                    //--------------end
                    )
                    . '>'
                    . $label . '</a>' . (($sub_label != '') ? ' '
                            . '<a ' .
                            //-------start sub
                            (
                            ##if
                            ($active_link) ?
                                    ##then
                                    'href="' . base_url(HOME_REDIRECT . $menu_current) . '"'

                            ##else
                                    : ''
                            )
                            //---------end sub
                            . ' class="current">'
                            . $sub_label
                            . '</a>' : '' );
                    ?> 
                </div>
                <h1><?php echo(($sub_label != '') ? $sub_label : $label ); ?></h1>
            </div>
            <!--End-breadcrumbs-->
