<?php
/*
Plugin Name: Restrict Access
Description: Restrict Access
Version: 1.0
Author: Marin Overcenco
Author wait soon
License: wait soon
*/

function restrict_access_install(){

    $post = array(
        'comment_status' => 'closed',
        'ping_status' =>  'closed' ,
        'post_author' => 1,
        'post_date' => date('Y-m-d H:i:s'),
        'post_name' => 'restrict_access',
        'post_status' => 'publish' ,
        'post_title' => 'Restrict Access',
        'post_type' => 'page',
    );

    wp_insert_post( $post, false );
}
register_activation_hook(__FILE__,'restrict_access_install');


function restrict_access_deactivate(){

    $id = get_posts('post_type=page&name=restrict_access');

    wp_delete_post($id[0]->ID,true);
}
register_deactivation_hook( __FILE__, 'restrict_access_deactivate' );


function restrict_access_init(){

    restrict_access_check();

    if($_SERVER['REQUEST_URI'] == '/restrict_access/'){

        restrict_access_scripts();
        restrict_access_get();
    }
}
add_action('init','restrict_access_init');


function restrict_access_scripts(){

    wp_register_style( 'my-restrict_access_css', plugins_url( 'restrict-access/style.css' ) );
    wp_enqueue_style( 'my-restrict_access_css' );

}

function restrict_access_check(){

    if(!is_user_logged_in() && $_SERVER['REQUEST_URI'] != '/restrict_access/'){

        wp_redirect('/restrict_access/');

        exit();
    }
}

function restrict_access_get(){

    if(isset($_POST['restrict_access_submit'])){

        $creds = array();
        $creds['user_login'] = $_POST['email'];
        $creds['user_password'] = $_POST['password'];
        $creds['remember'] = true;

        $user = wp_signon( $creds, false );

        if ( $user && !is_wp_error($user) ){

            wp_redirect('/');

            exit;
        }
        else{

            return $user;
        }
    }
}


