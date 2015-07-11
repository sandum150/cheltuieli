<?php
/*
 * Template Name: Setting
 */
get_header();
$user_options = get_user_option('settings', get_current_user_id());

$field_options = get_option('wpcf-fields');
echo "<pre>";
print_r($field_options);
echo "</pre>";


?>

    <form action="post" method="post">
        <label for="add_category">Add Category</label>
        <input type="text" name="category"/>
        <span id="add_category" class="add_setting" the_action="add">Adauga</span>
    </form>


<pre>
    <p id="result"></p>
</pre>

<div class="right sidebar">
<?php get_sidebar(); ?>
</div>

<?php get_footer();?>