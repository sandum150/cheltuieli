<html>
<head>
    <title>Tutorial theme</title>
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri() . '/css/jquery-ui.css'?>">
    <script src="<?php echo get_template_directory_uri() . '/js/jquery-1.11.2.min.js'?>"></script>
    <script src="<?php echo get_template_directory_uri() . '/js/jquery-ui-1.11.2.custom/jquery-ui.min.js'?>"></script>
    <script type="text/javascript" src="<?php echo get_template_directory_uri() . '/js/functions.js';?>"></script>
    <script>
        ajaxurl = "<?=admin_url('admin-ajax.php');?>";
        user_id = "<?=get_current_user_id();?>";
    </script>
</head>
<body>
<div id="popup">
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
</div>
<div id="wrapper">
    <div id="header">
        <h1>HEADER</h1>

        <div class="top-menu">
            <?php
            $defaults = array(
                'theme_location'  => '',
                'menu'            => '',
                'container'       => 'div',
                'container_class' => '',
                'container_id'    => '',
                'menu_class'      => 'menu',
                'menu_id'         => '',
                'echo'            => true,
                'fallback_cb'     => 'wp_page_menu',
                'before'          => '',
                'after'           => '',
                'link_before'     => '',
                'link_after'      => '',
                'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                'depth'           => 0,
                'walker'          => ''
            );

            wp_nav_menu( $defaults );
            ?>
        </div>
    </div>
    <div id="body">