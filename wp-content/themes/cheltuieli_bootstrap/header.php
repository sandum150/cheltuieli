<html>
<head>
    <title>Cheltuieli</title>
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">

<!--    fonts-->
    <link href='http://fonts.googleapis.com/css?family=Raleway:300,500,700' rel='stylesheet' type='text/css'>

<!--    jquery-->
    <link rel="stylesheet" href="<?php echo get_template_directory_uri() . '/css/jquery-ui.css'?>">
    <script src="<?php echo get_template_directory_uri() . '/js/jquery-1.11.2.min.js'?>"></script>
    <script src="<?php echo get_template_directory_uri() . '/js/jquery-ui-1.11.2.custom/jquery-ui.min.js'?>"></script>
    <script src="<?php echo get_template_directory_uri() . '/js/jquery.mobile.custom.min.js'?>"></script>

    <!--    bootsrap-->
    <link rel="stylesheet" href="<?php echo get_template_directory_uri() . '/bootstrap/css/bootstrap.min.css'?>">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri() . '/bootstrap/css/bootstrap-theme.min.css'?>">
    <script type="text/javascript" src="<?php echo get_template_directory_uri() . '/bootstrap/js/bootstrap.min.js';?>"></script>

    <!--    custom js scripts-->
    <script type="text/javascript" src="<?php echo get_template_directory_uri() . '/js/functions.js';?>"></script>
    <script>
        ajaxurl = "<?=admin_url('admin-ajax.php');?>";
        user_id = "<?=get_current_user_id();?>";
    </script>
</head>
<body>

<!--<div id="popup">
    <div id="popup_container">
        <div id="delete_category" class="popup">
            <h2> Sunteti sigur?</h2>
            <p>In categoria "<span id="category_name"></span>" exista <span id="count_categories">0</span> inregistrari. Toate ele vor fi sterse. Stergerea lor ar putea dura cateva minute.</p>
            <input type="hidden" id="setting">
            <span class="ok button">OK</span>
            <span class="cancel button">Cancel</span>
        </div>
        <div id="progress_container">
            <h2>Stergere..</h2>
            <div id="progressbar"></div>
        </div>
    </div>
</div>-->
<div id="wrapper" class="container">
    <div id="header">
        <h1><a href="/">Cheltuieli</a></h1>
        <nav class="navbar navbar-default">
            <div class="">
                <?php
                $my_walker = new MyMenu();
                $defaults = array(
                    'theme_location'  => '',
                    'menu'            => '',
                    'container'       => 'div',
                    'container_class' => 'navbar-collapse collapse',
                    'container_id'    => 'iii',
                    'menu_class'      => '',
                    'menu_id'         => '',
                    'echo'            => true,
                    'fallback_cb'     => 'wp_page_menu',
                    'before'          => '',
                    'after'           => '',
                    'link_before'     => '',
                    'link_after'      => '',
                    'items_wrap'      => '<ul class="nav navbar-nav">%3$s</ul>',
                    'depth'           => 0,
                    'walker'          => $my_walker
                );

                wp_nav_menu( $defaults );
                ?>
            </div>
        </nav>

    </div>
    <div id="body">