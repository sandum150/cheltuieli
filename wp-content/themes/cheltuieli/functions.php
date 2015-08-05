<?php
/**
 * Created by PhpStorm.
 * User: sandu
 * Date: 2/22/15
 * Time: 9:29 AM
 */
add_theme_support( 'menus' );

/*add_action( 'init', 'create_post_type' );
function create_post_type() {
    register_post_type( 'cheltuieli',
        array(
            'labels' => array(
                'name' => __( 'Cheltuieli' ),
                'singular_name' => __( 'Cheltuaiala' ),
                'add_new' => __( 'Adauga o cheltuiala' )
            ),
            'public' => true,
            'has_archive' => true,
            'supports' => array( 'title', 'editor', 'custom-fields' )
        )
    );
}


// hook into the init action and call create_book_taxonomies when it fires
add_action( 'init', 'create_cheltuieli_taxonomies', 0 );

// create two taxonomies, genres and writers for the post type "book"
function create_cheltuieli_taxonomies()
{

    // Add new taxonomy, NOT hierarchical (like tags)
    $labels = array(
        'name' => _x('Categorii', 'categoria cheltuielii'),
        'singular_name' => _x('Categorie', 'categorie'),
        'search_items' => __('Cauta categorii'),
        'popular_items' => __('Categorii populare'),
        'all_items' => __('Toate categoriile'),
        'parent_item' => null,
        'parent_item_colon' => null,
        'edit_item' => __('Editeaza categoria'),
        'update_item' => __('Innoieste categoria'),
        'add_new_item' => __('Adauga o categorie noua'),
        'new_item_name' => __('Denumirea categoriei'),
        'separate_items_with_commas' => __('Separarea categoriilor prin virgula'),
        'add_or_remove_items' => __('Adauga sau sterge categorii'),
        'choose_from_most_used' => __('Alege din cele mai utilizate categorii'),
        'not_found' => __('Nu au fost gasite categorii.'),
        'menu_name' => __('Categorii de cheltuieli'),
    );

    $args = array(
        'hierarchical' => false,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'update_count_callback' => '_update_post_term_count',
        'query_var' => true,
        'rewrite' => array('slug' => 'cheltuieli'),
    );

    register_taxonomy('categorie', 'cheltuieli', $args);
}*/

add_action('init', 'my_rem_editor_from_post_type');
function my_rem_editor_from_post_type() {
    remove_post_type_support( 'cheltuieli', 'editor' );
}

add_filter( 'posts_where', 'wp_like_post_title_where', 10, 2 );
function wp_like_post_title_where( $where, &$wp_query )
{
    global $wpdb;
    if ( $wp_like_post_title = $wp_query->get( 'wp_like_post_title' ) ) {
        $where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'' . '%' . esc_sql( $wpdb->esc_like( $wp_like_post_title ) ) . '%\'';
    }
    return $where;
}


function example_ajax_request() {
    // The $_REQUEST contains all the data sent via ajax
    if ( isset($_REQUEST) ) {

        $fruit = $_REQUEST['fruit'];

        // Let's take the data that was sent and do something with it
        if ( $fruit == 'Banana' ) {
            $fruit = 'Apple';
        }

        // Now we'll return it to the javascript function
        // Anything outputted will be returned in the response
//        echo $fruit. "\n";
//        echo get_the_title( $_REQUEST['post_id']);
        $post = get_post($_REQUEST['post_id']);
        echo get_post_field('wpcf-data-cheltuielii', 478);
//        echo $post->post_content;

        // If you're debugging, it might be useful to see what was sent in the $_REQUEST
        // print_r($_REQUEST);

    }

    // Always die in functions echoing ajax content
    die();
}
add_action( 'wp_ajax_example_ajax_request', 'example_ajax_request' );
// If you wanted to also use the function for non-logged in users (in a theme for example)
add_action( 'wp_ajax_nopriv_example_ajax_request', 'example_ajax_request' );

function draw_setting($setting = NULL){
    $user_settings = get_user_option('settings', get_current_user_id());
    $settings = $user_settings[$setting];
    if(count($settings) > 0){
        foreach($settings as $key => $list){
            echo "<p><span class='settings_list'>$list</span><span class='edit_".$setting."' the_action='edit' key='$key'>Edit </span><span class='delete_setting' the_action='delete' key='$key'>Delete</span></p>";
        }
    }else
        echo "Nu sunt inregistrari in setari.";
}

function change_settings_in_postmeta($setting, $old_val, $new_val){
    global $wpdb;
    $resut = $wpdb->update(
        'wp_postmeta',
        array(
            'meta_value' => $new_val
        ),
        array(
            'meta_key' => 'wpcf-'.$setting.'-'.get_current_user_id(),
            'meta_value' => $old_val
        )
    );
    return $resut;
}

function delete_posts_from_category($setting_name, $setting){
    $args = array(
        'posts_per_page'   => 1,
        'post_type'   => 'cheltuieli',
        'author'	   => '',
        'post_status'      => 'publish',
        'meta_query' => array(
            array(
                'key' => 'wpcf-'.$setting.'-'.get_current_user_id(),
                'value' => $setting_name,
            )
        )
    );
    $posts_array = get_posts( $args );

    $count = 0;
    foreach($posts_array as $post){
        wp_delete_post($post->ID, true);
        $count++;
//        echo $post->ID;
    }
    if($count < 1)
        return true;
    else
        return false;
}

function update_user_settings(){
    $user_settings = get_user_option('settings', get_current_user_id());
//    If settings allready exists
    if(!empty($user_settings)) {
        $categories = $user_settings['categories'];
        $beneficiars = $user_settings['beneficiars'];

        if (!$beneficiars){
            $beneficiars = array();
        }
//        Add new category
        if($_REQUEST['the_action']=="add" && $_REQUEST['setting']=="category"){
            if (!empty($categories)){
                $categories[] .= $_REQUEST['category'];
            }else{
                $categories = array();
                $categories[] .= $_REQUEST['category'];
            }
            $draw_categories = true;
        }
//        Add new beneficiar
        if ( $_REQUEST['the_action'] == "add" && $_REQUEST['setting'] == "beneficiars" ){
            if (!empty($beneficiars)){
                $beneficiars[] .= $_REQUEST['beneficiar'];
            }else{
                $beneficiars = array();
                $beneficiars[] .= $_REQUEST['beneficiar'];
            }
            $draw_beneficiars = true;
        }

//        Delete the category from array
        if($_REQUEST['the_action'] == 'delete' && $_REQUEST['key'] != ""){
            $key = $_REQUEST['key'];
            reset($categories);
            reset($beneficiars);

            $result = delete_posts_from_category($_REQUEST['category_name'], $_REQUEST['setting']);
            if ($_REQUEST['setting'] == "beneficiar"){
                $draw_beneficiars = $result;
            }
            if ($_REQUEST['setting'] == "categoria"){
                $draw_categories = $result;
            }
//            $draw_beneficiars = $_REQUEST['setting'] == "beneficiar"?$result:true;
//            $draw_categories = $_REQUEST['setting'] == "categoria"?$result:true;
            if($result){
                if($_REQUEST['setting'] == 'categoria')
                    unset($categories[(int)$key]);
                if($_REQUEST['setting'] == 'beneficiar')
                    unset($beneficiars[(int)$key]);
                delete_posts_from_category($_REQUEST['category_name'], $_REQUEST['setting']);
            }
        }

//        Edit existing category
        if($_REQUEST['the_action'] == 'edit' && $_REQUEST['setting'] == 'category'){
            $setting = $_REQUEST['setting'] == "category" ? "categoria":"beneficiar";
            change_settings_in_postmeta($setting, $categories[$_REQUEST['key']], $_REQUEST['new_value']);
            $categories[$_REQUEST['key']] = $_REQUEST['new_value'];
            $draw_categories = true;
        }
//        Edit existing beneficiar
        if($_REQUEST['the_action'] == 'edit' && $_REQUEST['setting'] == 'beneficiars'){
            $setting = $_REQUEST['setting'] == "beneficiars" ? "beneficiar":"categoria";
            change_settings_in_postmeta($setting, $beneficiars[$_REQUEST['key']], $_REQUEST['new_value']);
            $beneficiars[$_REQUEST['key']] = $_REQUEST['new_value'];
            $draw_beneficiars = true;
        }

        $user_settings['categories'] = $categories;
        $user_settings['beneficiars'] = $beneficiars;
        $result_update = update_user_option(get_current_user_id(), 'settings', $user_settings);
        if($draw_categories)
            draw_setting("categories");
        if($draw_beneficiars)
            draw_setting("beneficiars");

    }else{

//      Initializing user settings
        $categories = Array();
        $beneficiars = Array();
        if (!empty($_REQUEST['category']))
            $categories[] .= $_REQUEST['category'];
        if (!empty($_REQUEST['beneficiar']))
            $beneficiars[] .= $_REQUEST['beneficiar'];
//        $categories[] .= $_REQUEST['category'];
//        $beneficiars[] .= $_REQUEST['beneficiar'];
        $user_settings = Array(
            'categories'    => $categories,
            'beneficiars'   => $beneficiars
        );
//        create user settings
        $result_update = update_user_option(get_current_user_id(), 'settings', $user_settings);
//        draw_setting("categories");
//        draw_setting("beneficiars");
        $_REQUEST['setting'] == "beneficiars"?draw_setting("beneficiars"):draw_setting("categories");
    }

    die();
}
add_action( 'wp_ajax_update_user_settings', 'update_user_settings' );
// If you wanted to also use the function for non-logged in users (in a theme for example)
//add_action( 'wp_ajax_nopriv_update_user_settings', 'update_user_settings' );


function count_posts_from_category(){
    $args = array(
        'posts_per_page'   => -1,
        'post_type'   => 'cheltuieli',
        'author'	   => '',
        'post_status'      => 'publish',
        'meta_query' => array(
            array(
                'key' => 'wpcf-'.$_REQUEST['setting'].'-'.get_current_user_id(),
                'value' => $_REQUEST['setting_name'],
            )
        )
    );
    $posts_array = get_posts( $args );
    echo count($posts_array);
die();
}
add_action( 'wp_ajax_count_posts_from_category', 'count_posts_from_category' );
