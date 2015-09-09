<?php

/*
Template Name: Pagination
 */
get_header();
?>

<script>
    ajaxurl = "<?=admin_url('admin-ajax.php');?>";
    post_id = "<?=get_the_ID();?>"
//    ajaxurl = 'http://wp.lan/wp-admin/admin-ajax.php';

    jQuery(document).ready(function($) {

        $("#test_ajax").click(function(){


            // We'll pass this variable to the PHP function example_ajax_request
            var fruit = 'Banana';

            // This does the ajax request
            $.ajax({
                url: ajaxurl,
                data: {
                    'action':'example_ajax_request',
                    'fruit' : fruit,
                    'post_id': post_id
                },
                success:function(data) {
                    // This outputs the result of the ajax request
                    //console.log(data);
                    $("#result").html(data);
                },
                error: function(errorThrown){
                    console.log(errorThrown);
                }
            });

        });

    });
</script>


<p id="test_ajax">click</p>
<p>&nbsp;</p>

<div id="result"></div>
<?php

//get_sidebar();
get_footer();