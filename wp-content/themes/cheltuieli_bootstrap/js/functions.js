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
    $('.clone-row').click(function(e){
        e.preventDefault();
        addRow();
    });

    //delete rows on press button
    $("#transactions .delete-row").on("click",function(e) {
        e.preventDefault();
        var tr = $(this).closest('tr.row');
        //tr.css("background-color","#A5C9F2");
        //console.log(22);
        if(tr.siblings('.row').length > 0){
            tr.fadeOut(200, function(){
                tr.remove();
            });
        }
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
        $("input[name=dela], input[name=panala]").val("")
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
    the_action  = $(this).attr('the_action');
    category    = $(this).closest('.tab-pane.active').find("input[name='category']");
    beneficiar  = $(this).closest('.tab-pane.active').find("input[name='beneficiar']");
    this_value  = $(this).closest('.tab-pane.active').find(".form-control").val();
    target_html = $(this).closest('.tab-pane.active').find(".panel-body > div");

    if (this_value == beneficiar.val()){
        setting = "beneficiars"
    }
    if (this_value == category.val()){
        setting = "category"
    }

    if (this_value != ""){
        $.ajax({
            url: ajaxurl,
            data: {
                'action'        : 'update_user_settings',
                'user_id'       : user_id,
                'the_action'    : the_action,
                'category'      : category.val(),
                'beneficiar'    : beneficiar.val(),
                'setting'       : setting

            },
            success:function(data) {
                //$(target_html).html(data);
                $(target_html).html(data);
                category.val("");
                beneficiar.val("");
            },
            error: function(errorThrown){
                console.log(errorThrown);
            }
        });
    }
})

//    progressbar
//    $("#progressbar").progressbar({
//        value: 0
//    });

//  delete category:
//  1. popup with confirmation
$(document).on("click", ".delete_setting", function(){
    $("#progress_container").hide();
    the_action = $(this).attr('the_action');
    key = $(this).attr('key');
    setting_name = $(this).closest('tr').find(".settings_list").text();


//  ckeck where we are
    if ($(this).closest('.panel-body > div').is("#categories_result")){
        setting = "categoria";
    }
    if ($(this).closest('.panel-body > div').is("#beneficiar_result")){
        setting = "beneficiar";
    }

    $.ajax({
        url: ajaxurl,
        data: {
            'action'        :'count_posts_from_category',
            'user_id'       : user_id,
            'the_action'    : the_action,
            'key'           : key,
            'setting'       : setting,
            'setting_name'  : setting_name

        },
        success:function(data) {
            //console.log(data);
            $("#count_categories").html(data);
            $("#category_name").html(setting_name);
            $(".ok.button").attr({
                category_name: setting_name,
                key: key
            });
            $("#setting").attr("name", setting);
            $("#popup, #delete_category").show();
            //progress = progress + data / 5;
            //$( "#progressbar" ).progressbar( "value", 0 );
        },
        error: function(errorThrown){
            console.log(errorThrown);
        }
    });

});

//    delete category
//    2. popup with progress bar
//    3. delete category with posts
$(document).on("click", ".btn.btn-danger.ok.button", function(){
    $("#progress_container").show();
    $("#delete_category").hide();
    key = $(this).attr("key");
    category = $(this).attr("category_name");
    setting = $("#setting").attr("name");
    count_categories = Number($("#count_categories").html());
    progress = 0;
    $.ajax({
            url: ajaxurl,
            data: {
                'action'        :'update_user_settings',
                'user_id'       : user_id,
                'the_action'    : 'delete',
                'key'           : key,
                'category_name' : category,
                'setting'       :setting

            },
            success:function(data) {
                if(data != ""){
                    if(setting == "beneficiar"){
                        $("#beneficiar_result").html(data);
                    }else{
                        $("#categories_result").html(data);
                    }
                    //$( "#progressbar" ).progressbar( "value", 100 );
                }else{
                    $(".btn.btn-danger.ok.button").trigger("click");
                    progress = parseFloat($("#progressbar").attr("aria-valuenow")) + 100 / count_categories;
                    //$( "#progressbar" ).progressbar( "value", progress );
                    $('#progressbar').attr('aria-valuenow', progress);
                    $('#progressbar').css('width', progress + '%');
                    $('#progressbar').text(Math.ceil(progress) + '%');
                }
            },
            error: function(errorThrown){
                console.log(errorThrown);
            }
        });
});
$(document).on("click", ".cancel.button", function(){
    $("#popup").hide();
});

//Edit category
$(document).on("click", ".edit_categories, .edit_beneficiars", function(){
    place = $(this).parent().prev().find('span');
    old_text = place.html();
    old_val = place.html();
    key = $(this).attr('key');

    if($(this).hasClass("edit_categories")){
        setting = "category";
        target_html = $("#categories_result");
    }
    if ($(this).hasClass("edit_beneficiars")){
        setting = "beneficiars";
        target_html = $("#beneficiar_result");
    }
    form = '<input class="form-control" id="edit_category_form" type="text" value="'+old_val+'">';
    place.replaceWith(form);
    new_place = $(this).parent().prev().find('input');
    new_place.focus();
    val_lenght = new_place.val().length;
    new_place[0].setSelectionRange(val_lenght, val_lenght);
    new_place.on("focusout", function(){
        new_val = new_place.val();
        if(new_val != ''){
            new_form = "<span class='settings_list'>"+ new_val +"</span>";
            new_place.replaceWith(new_form);
        }
        if(old_val != new_val && new_val != ''){
            $.ajax({
                url: ajaxurl,
                data: {
                    'action':'update_user_settings',
                    'the_action': 'edit',
                    'key'       : key,
                    'new_value' : new_val,
                    'setting'   : setting

                },
                success:function(data) {
                    target_html.html(data);
                },
                error: function(errorThrown){
                    console.log(errorThrown);
                }
            });
        }
    });

});


// editing in front the post
    $("#transactions td").dblclick(function(){
        cell = $(this);
        th = $('#transactions th').eq(cell.index());
        if(cell.parent().attr("ch_id") && th.attr("field") && !cell.hasClass("editing_cell")){
            //cell.addClass("editing_cell");
            old_text = cell.html();
            old_val = cell.html();

            //working with categoria and beneficiar (we need select options)
            if(th.attr("field") == "beneficiar" || th.attr("field") == "categoria"){

                $.ajax({
                    url: ajaxurl,
                    data: {
                        'action'    :'getSettingList'
                    },
                    success:function(data) {
                        new_html ='<select class="form-control"></select>';
                        cell.html(new_html);
                        new_element = cell.find("select");
            //draw the select options
                        var obj = $.parseJSON(data);
                        th.attr("field") == "beneficiar" ? setting_list = obj.beneficiars : setting_list = obj.categories;
                        $.each(setting_list, function(key,value) {
                            old_val == value ? selected = "selected" : selected = " ";
                            new_element.append('<option '+ selected +' value="' + value + '">' + value + '</option>');
                        });
                        new_element.focus();
            // listening the events
                        new_element.on('keydown', catchEvent);
                        new_element.on("focusout", catchEvent);
                    }
                });
            };
            //working with destinatia
            if(th.attr("field") == "destinatia" ||  th.attr("field") == "suma"){
                new_html = '<input class="form-control" name="edit_cheltuiala" value="'+old_val+'">';
                cell.html(new_html);
                new_element = cell.find("input");
                new_element.focus();

                //set cursor to the end
                val_lenght = new_element.val().length;
                new_element[0].setSelectionRange(val_lenght, val_lenght);
                new_element.on('keydown', catchEvent);
                new_element.on("focusout", catchEvent);
            };
            if(th.attr('field') == 'data'){
                old_text = cell.text();
                old_val = cell.text();
                old_val = old_val.substring(0, old_val.indexOf(','));

                new_html = '<input class="form-control" type="text" name="dataop" value="'+old_val+'">';
                cell.html(new_html);
                options_data = {
                    dateFormat:     'dd-mm-yy ',
                    firstDay:       1,
                    onSelect: function(e){
                        saveCheltuialaField(cell.parent().attr("ch_id"), th.attr("field"), e);
                    },
                    onClose: function(e){
                        cell.text(old_text);
                        cell.removeClass("editing_cell");
                    }
                };
                new_element = cell.find('input');
                new_element.datepicker(options_data);
                new_element.datepicker('show');
            }
        }
    });




//Save new value
    function catchEvent(e){
        //if focus out or press enter
        if(e.type == "change" || e.type == "focusout" || e.which == 13 || e.keyCode == 13){
            new_element.attr("disabled", "");
            if(old_val != new_element.val()){
                saveCheltuialaField(cell.parent().attr("ch_id"), th.attr("field"), new_element.val());
            }else{
                cell.text(old_text);
                cell.removeClass("editing_cell");
            }
        }else{

        }
        //if press ESC we keep the old value
        if(e.keyCode == 27 || e.which == 27){
            cell.removeClass("editing_cell");
            cell.html(old_text);
        }
    }

    function saveCheltuialaField(post_id, field, value){
        $.ajax({
            url: ajaxurl,
            data: {
                'action'    :'updateCheltualaField',
                'post_id'   : post_id,
                'field_name': field,
                'value'     : value
            },
            success:function(data) {
                cell.removeClass("editing_cell");
                cell.text(data);
            },
            error: function(errorThrown){
                console.log(errorThrown);
            }
        });
    }


    $("#toggle_select_categories").click(function(e){
        e.preventDefault();
        $('input[name=categoria\\[\\]]').trigger('click');
    });



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


//update database
$(document).ready(function(){
    $("#database_update").click(function(){
        $.ajax({
            url: ajaxurl,
            data: {
                'action'    :'updateDatabase'
            },
            success:function(data) {
                $("#database_info").html(data);
            },
            error: function(errorThrown){
            }
        });
    });
});
