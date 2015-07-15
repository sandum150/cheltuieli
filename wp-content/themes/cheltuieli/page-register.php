<?php
/*
 Template name: Adauga cheltuieli
 * Created by PhpStorm.
 * User: sandu
 * Date: 2/22/15
 * Time: 2:15 PM
 */

// Create post object

if (!empty($_POST) && $_POST['date'] != ''){
  for ($i=0; $i<count($_POST['date']); $i++){
      $my_post = array(
          'post_type'             => 'cheltuieli',
          'post_title'            => $_POST['destinatia'][$i],
          'post_status'           => 'publish',
          'post_author'           => get_current_user_id()
      );
      $pid = wp_insert_post( $my_post );
      add_post_meta($pid, 'wpcf-data-cheltuielii', strtotime($_POST['date'][$i]));
      add_post_meta($pid, 'wpcf-categoria-'.get_current_user_id(), $_POST['categoria'][$i]);
      add_post_meta($pid, 'wpcf-beneficiar', $_POST['beneficiar'][$i]);
      add_post_meta($pid, 'wpcf-suma', $_POST['amount'][$i]);
  }
}


get_header();


$custom_fields = get_option( 'wpcf-fields' );

//?>
<div class="left page">
    <form id="transactions" method="post" action="">
    <table id="tablefields">
        <tr>
            <td>Data</td>
            <td>Categoria</td>
            <td>Destinatia</td>
            <td>Beneficiar</td>
            <td>Suma</td>
        </tr>
        <tr class="row">
            <td>
                <input type="text" name="date[]" class="datepicker defined" autocomplete="off"><br>
            </td>
            <td>
                <select name="categoria[]" class="categoria">
                    <?php
                    $categorii = get_user_option('settings', get_current_user_id());
                    foreach ($categorii['categories'] as $categorie){
                        echo '<option value="'.$categorie.'">'.$categorie.'</option>';
                    }
                    ?>
                </select>
            </td>
            <td>
                <input type="text" name="destinatia[]" class="destinatia"><br>
            </td>
            <td>
                <select name="beneficiar[]" class="beneficiar">
                    <?php
                    $beneficiari = $custom_fields['beneficiar']['data']['options'];
                    foreach ($beneficiari as $beneficiar){
                        echo '<option value="'.$beneficiar['value'].'">'.$beneficiar['title'].'</option>';
                    }
                    ?>
                </select>
            </td>
            <td>
                <input type="text" name="amount[]" size="4" class="amount" autocomplete="off"><br>

            </td>
            <td>
                <span class="clone-row">add</span>
                <span class="delete-row">detele</span>
            </td>
        </tr>

    </table>

    <button id="submitMe">Save</button>
</form>
</div>
<div class="right sidebar">
<?php
get_sidebar();
?>
</div>
<?php
get_footer();