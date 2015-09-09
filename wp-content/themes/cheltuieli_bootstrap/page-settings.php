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
<div class="col-sm-9">

    <div>

        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#categorii" aria-controls="categorii" role="tab" data-toggle="tab">Categorii</a></li>
            <li role="presentation" ><a href="#beneficiari" aria-controls="beneficiari" role="tab" data-toggle="tab">Beneficiari</a></li>
            <li role="presentation"><a href="#update" aria-controls="Update" role="tab" data-toggle="tab">Update</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">

            <div role="tabpanel" class="tab-pane active" id="categorii">

                <div class="col-sm-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Adauga categorii</h3>
                        </div>
                        <div class="panel-body">
                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="add_category"></label>
                                    <input type="text" name="category" class="form-control" placeholder="Denumire categorie"/>
                                </div>

<!--                                <span id="add_category" class="add_setting" the_action="add">Adauga</span>-->
                                <button type="button" class="btn btn-success add_setting" the_action="add" id="add_category">Adauga</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Categorii existente</h3>
                        </div>
                        <div class="panel-body">
                            <div id="categories_result">
                                <?php draw_setting("categories");?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div role="tabpanel" class="tab-pane " id="beneficiari">

                <div class="col-sm-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Adauga beneficiari</h3>
                        </div>
                        <div class="panel-body">
                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="add_beneficiar"></label>
                                    <input  class="form-control" placeholder="Denumire beneficiar" type="text" name="beneficiar" />
                                </div>
                            </form>
<!--                            <span id="add_beneficiar" class="add_setting" the_action="add">Adauga</span>-->
                            <button type="button" class="btn btn-success add_setting" the_action="add" id="add_beneficiar">Adauga</button>

                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Beneficiari existenti</h3>
                        </div>
                        <div class="panel-body">
                            <div id="beneficiar_result">
                                <?php draw_setting("beneficiars");?>
                            </div>
                        </div>
                    </div>
                </div>
                <!--<form action="" method="post">
                    <label for="add_beneficiar">Adauga Beneficiar</label>
                    <input  type="text" name="beneficiar" />
                    <span id="add_beneficiar" class="add_setting" the_action="add">Adauga</span>
                </form>
                <div id="beneficiar_result">
                    <?php /*draw_setting("beneficiars");*/?>
                </div>-->
            </div>
            <div role="tabpanel" class="tab-pane" id="update">
                <p id="database_info">Careva modificari au fost facute in baza de date. Apasati butonul pentru a actualiza</p>
                <button id="database_update">Actualizeaza</button>
            </div>
        </div>

        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
            Launch demo modal
        </button>

        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Sunteti sigur?</h4>
                    </div>
                    <div class="modal-body">
                        <div id="delete_category" class="popup">

                            <p>In categoria "<span id="category_name"></span>" exista <span id="count_categories">0</span> inregistrari. Toate ele vor fi sterse. Stergerea lor ar putea dura cateva minute.</p>
                            <input type="hidden" id="setting">
                        </div>
                        <div class="progress">
                            <div id="progressbar"  aria-valuemax="100" aria-valuemin="0" aria-valuenow="0" role="progressbar" class="progress-bar">0%</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default cancel button" data-dismiss="modal">Inchide</button>
                        <button type="button" class="btn btn-danger ok button">Sterge</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <?php
    //echo "<pre>";
    //var_dump($user_settings);
    //echo "</pre>";
    ?>
</div>


<div class="col-sm-3">
<?php get_sidebar(); ?>
</div>

<?php get_footer();?>