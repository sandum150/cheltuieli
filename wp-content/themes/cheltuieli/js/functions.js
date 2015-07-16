$( document ).ready(function() {

    //datepicker
    var options = {
        dateFormat:     'yy-mm-dd',
        firstDay:       1
    };
    $('.datepicker').datepicker(options);
    $('.datepicker.defined').datepicker("setDate", new Date() );


    //add row
    function addRow()
    {
        lastDate = $('.row:last .datepicker.defined').val();
        rowcontent = $('.row:last');
        $('.datepicker').datepicker('destroy').removeClass('hasDatepicker').attr('id',"");
        rowcontent.clone(true).find('input').val('').end().append().insertAfter('.row:last');
        $('.datepicker').datepicker(options);
        $('.row:last .datepicker.defined').datepicker("setDate", lastDate );

    };

    //prevent from submitting form
    $('.destinatia, .categoria, .datepicker').on('keypress', function(e) {
        if (e.which == 13 || e.keyCode == 13) {
            e.preventDefault();
        }
    });

    //add new row on press enter key
    $('.amount').on('keypress', function(e) {
        if (e.which == 13 || e.keyCode == 13) {
            e.preventDefault();
            addRow();
        }
    });

    //add new row on press button
    $('.clone-row').click(function(){
        addRow();
    });

    //delete rows on press button
    $("#transactions .delete-row").on("click",function() {
        var tr = $(this).closest('tr');
        tr.css("background-color","#A5C9F2");
        tr.fadeOut(400, function(){
            tr.remove();
        });
        return false;
    });


    //key control focus
    //$('input').on('keypress', function(e) {
    //    if (e.which == 69 || e.keyCode == 69) {
    //        e.preventDefault();
    //        $(this).next('input').focus();
    //        console.log('wwwww');
    //    }
    //});
    $(".datepicker.hasDatepicker").change(function(){
        //console.log('changed');
        $(".perioada").val("");
    });

    $(".perioada").change(function(){
        $(".datepicker.hasDatepicker").val("")
    })


    //var canvas = document.getElementById('myCanvas');
    //var context = canvas.getContext('2d');
    //var width = 600;
    //var height = 600;
    //context.beginPath();
    //
    //context.moveTo(0, 200);
    //
    //for (i=0; i<=width; i+=60){
    //    context.lineTo(i, Math.floor((Math.random() * 200) + 1));
    //
    //}
    //
    //context.lineJoin = 'round';
    //context.lineWidth = 5;
    //context.strokeStyle = '#ff0000';
    //
    //context.stroke();
    //
    //var canvas2 = document.getElementById('myCanvas');
    //var grid = canvas2.getContext('2d');
    //
    //grid.beginPath();
    //grid.lineWidth = 0.5;
    //for (j=0; j<=width; j+=width/20){
    //    grid.moveTo(j, 0);
    //    grid.lineTo(j, width);
    //    grid.moveTo(0, j);
    //    grid.lineTo(height, j);
    //
    //}
    //context.strokeStyle = '#000000';
    //grid.stroke();
//    -----------------------------------------------------------------------------------


//add category
$(".add_setting").click(function(){
    the_action = $(this).attr('the_action');
    category = $("input[name='category']").val();
    key = $(this).attr('key');
    console.log(key);

    $.ajax({
        url: ajaxurl,
        data: {
            'action':'update_user_settings',
            'user_id' : user_id,
            'the_action' : the_action,
            'category' : category

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
})

//  delete category:
//  1. popup with confirmation
$(document).on("click", ".delete_category", function(){
    the_action = $(this).attr('the_action');
    key = $(this).attr('key');
    category = $(this).parent().find(".category_list").html();
    //console.log(category);
    $.ajax({
        url: ajaxurl,
        data: {
            'action':'count_posts_from_category',
            'user_id' : user_id,
            'the_action' : the_action,
            'key' : key,
            'category_name': category

        },
        success:function(data) {
            // This outputs the result of the ajax request
            //console.log(data);
            $("#count_categories").html(data);
            $("#category_name").html(category);
            $(".ok.button").attr({
                category_name: category,
                key: key
            });
            $("#popup, #delete_category").show();
        },
        error: function(errorThrown){
            console.log(errorThrown);
        }
    });

});

//    delete category
//    2. popup with progress bar
//    3. delete category with posts
$(document).on("click", "#delete_category .ok.button", function(){
    key = $(this).attr("key");
    category = $(this).attr("category_name");
    $.ajax({
            url: ajaxurl,
            data: {
                'action':'update_user_settings',
                'user_id' : user_id,
                'the_action' : 'delete',
                'key' : key,
                'category_name': category

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

//Edit category
$(document).on("click", ".edit_category", function(){
    place = $(this).prev();
    old_val = place.html();
    key = $(this).attr('key');
    //console.log(key);
    form = '<input id="edit_category_form" type="text" value="'+old_val+'">';
    place.replaceWith(form);
    new_place = $(this).prev();
    new_place.focus();
    val_lenght = new_place.val().length;
    new_place[0].setSelectionRange(val_lenght, val_lenght);
    new_place.on("focusout", function(){
        new_val = new_place.val();
        new_form = "<span class='category_list'>"+ new_val +"</span>";
        //console.log(new_form);
        new_place.replaceWith(new_form);
        if(old_val != new_val){
            //console.log(key);
            $.ajax({
                url: ajaxurl,
                data: {
                    'action':'update_user_settings',
                    'the_action' : 'edit',
                    'key' : key,
                    'new_value' : new_val

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
        }else{
            //console.log("is equal");
        }
    });

})





});

$(document).mouseup(function (e)
{
    var container = $("#popup_container");

    if (!container.is(e.target) // if the target of the click isn't the container...
        && container.has(e.target).length === 0) // ... nor a descendant of the container
    {
        container.parent().hide();
    }
});
/**
 * Created by sandum on 11.01.2015.
 */

