<?php
/*
 * Template Name: Setting
 */
get_header();
$user_options = get_user_option('settings', get_current_user_id());

$field_options = get_option('wpcf-fields');
//echo "<pre>";
//print_r($field_options);
//echo "</pre>";


?>
<div class="left page">
    <form action="" method="post">
        <label for="add_category">Adauga Categorie</label>
        <input type="text" name="category"/>
        <span id="add_category" class="add_setting" the_action="add">Adauga</span>
    </form>
    <div id="categories_result">
        <?php draw_setting("categories");?>
    </div>
    <form action="" method="post">
        <label for="add_beneficiar">Adauga Beneficiar</label>
        <input  type="text" name="beneficiar" />
        <span id="add_beneficiar" class="add_setting" the_action="add">Adauga</span>
    </form>
    <div id="beneficiar_result">
        <?php draw_setting("beneficiars");?>
    </div>
    <?php

    //echo "<pre>";
    //var_dump($user_settings);
    //echo "</pre>";
    ?>
</div>


<div class="right sidebar">
<?php get_sidebar(); ?>
</div>

<?php get_footer();?>