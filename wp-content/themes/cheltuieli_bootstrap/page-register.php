<?php
/*
 Template name: Adauga cheltuieli
 * Created by PhpStorm.
 * User: sandu
 * Date: 2/22/15
 * Time: 2:15 PM
 */

// Create post object
$user_id = get_current_user_id();
if (!empty($_POST) && $_POST['date'] != ''){
  for ($i=0; $i<count($_POST['date']); $i++){
      $my_post = array(
          'post_type'             => 'cheltuieli',
          'post_title'            => $_POST['destinatia'][$i],
          'post_status'           => 'publish',
          'post_author'           => $user_id
      );
      $pid = wp_insert_post( $my_post );
      add_post_meta($pid, 'wpcf-data-cheltuielii-'.$user_id, strtotime($_POST['date'][$i]));
      add_post_meta($pid, 'wpcf-categoria-'.$user_id, $_POST['categoria'][$i]);
      add_post_meta($pid, 'wpcf-beneficiar-'.$user_id, $_POST['beneficiar'][$i]);
      add_post_meta($pid, 'wpcf-suma-'.$user_id, $_POST['amount'][$i]);
  }
}


get_header();


$custom_fields = get_option( 'wpcf-fields' );

//?>
<div class="row">
    <div class="col-sm-9">
        <form id="transactions" method="post" action="">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr class="row mytable">
                            <th width="100">Data</th>
                            <th width="125">Categoria</th>
                            <th>Destinatia</th>
                            <th>Beneficiar</th>
                            <th>Suma</th>
                            <th width="80"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="row mytable">
                            <td>
                                <input type="text" name="date[]" class="datepicker defined form-control" autocomplete="off">
                            </td>
                            <td>
                                <select name="categoria[]" class="categoria form-control">
                                    <?php $categorii = get_user_option('settings', $user_id);
                                    foreach ($categorii['categories'] as $categorie){
                                    echo '<option value="'.$categorie.'">'.$categorie.'</option>';
                                    }?>
                                </select>
                            </td>
                            <td>
                                <input type="text" name="destinatia[]" class="destinatia form-control" placeholder="Destinatia">
                            </td>
                            <td>
                                <select name="beneficiar[]" class="beneficiar form-control">
                                    <?php foreach ($categorii['beneficiars'] as $categorie){
                                    echo '<option value="'.$categorie.'">'.$categorie.'</option>'; }?>
                                </select>
                            </td>
                            <td>
                                <input type="text" name="amount[]" size="4" class="amount form-control" autocomplete="off" placeholder="suma">
                            </td>
                            <td>
                                <button class="btn btn-info clone-row">N</button>
                                <button class="btn btn-danger delete-row">X</button>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>

  <!--              <div class="row2">
                    <div class="col-sm-2">
                        Data
                    </div>
                    <div class="col-sm-2">
                        Categoria
                    </div>
                    <div class="col-sm-4">
                        Destinatia
                    </div>
                    <div class="col-sm-1">
                        Beneficiar
                    </div>
                    <div class="col-sm-1">
                        Suma
                    </div>
                    <div class="col-sm-2">
                        &nbsp;
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2">
                        <input type="text" name="date[]" class="datepicker defined form-control" autocomplete="off">
                    </div>

                    <div class="col-sm-2">
                        <select name="categoria[]" class="categoria form-control">
                            <?php /*$categorii = get_user_option('settings', $user_id);
                            foreach ($categorii['categories'] as $categorie){
                                echo '<option value="'.$categorie.'">'.$categorie.'</option>';
                            }*/?>
                        </select>
                    </div>

                    <div class="col-sm-4">
                        <input type="text" name="destinatia[]" class="destinatia form-control" placeholder="Destinatia">
                    </div>

                    <div class="col-sm-1">
                        <select name="beneficiar[]" class="beneficiar form-control">
                            <?php /*foreach ($categorii['beneficiars'] as $categorie){
                                echo '<option value="'.$categorie.'">'.$categorie.'</option>';
                            }*/?>
                        </select>
                    </div>

                    <div class="col-sm-1">
                        <input type="text" name="amount[]" size="4" class="amount form-control" autocomplete="off" placeholder="suma">
                    </div>

                    <div class="col-sm-2">
                        <button class="btn btn-info clone-row">Nou</button>
                        <button class="btn btn-danger delete-row">Sterge</button>
<!--                        <span class="clone-row">add</span>-->
<!--                        <span class="delete-row">detele</span>-->
<!--                    </div>-->

<!--                </div>-->

            <button id="submitMe" class="btn btn-success">Salveaza</button>
        </form>
    </div>
    <div class="col-sm-3">
        <?php
        get_sidebar();
        ?>
    </div>


</div>

<?php
get_footer();