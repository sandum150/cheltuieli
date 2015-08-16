<?php
/*
 Template name: Vizualizare cheltuieli
 * Created by PhpStorm.
 * User: sandu
 * Date: 2/23/15
 * Time: 7:31 AM
 */
get_header();
//echo '<pre>';
//var_dump($_POST);
//echo '</pre>';

//arguments for query
$dela = strtotime($_POST['dela']);
$panala = strtotime($_POST['panala']);
if($dela == false){
    $current_day = date("w", time()); //day number of week -1 (0 is sunday; 6 is saturday)
    $current_day == 0 ? $current_day = 6 : $current_day = $current_day - 1;
    $dela = strtotime(" -$current_day day", strtotime("00:00:00"));
}

if($panala == false)
    $panala = time();

//current period
if ($_POST['perioada'] != ''){
    $panala = time();
    switch ($_POST['perioada']){
        case 1:
            $dela = strtotime("00:00:00"); //today
            break;
        case 2:
            $current_day = date("w", time()); //day number of week -1 (0 is sunday; 6 is saturday)
            $current_day == 0 ? $current_day = 6 : $current_day = $current_day - 1;
            $dela = strtotime(" -$current_day day", strtotime("00:00:00"));
            break;
        case 3:
            $current_date = date("d", time())-1;
            $dela = strtotime(" -$current_date day", strtotime("00:00:00"));
            break;
        default: // default is current week
            $current_day = date("w", time())-1; //day number of week -1 (0 is sunday; 6 is saturday)
            $dela = strtotime(" -$current_day day", strtotime("00:00:00"));
            break;
    }
}


if ($_POST['categoria'] == 0){
    $value_cat = '';
    $like_cat  = 'LIKE';
}else{
    $value_cat = $_POST['categoria'];
    $like_cat = 'IN';
}
$args = array(
    'post_type'  => 'cheltuieli',
    'meta_key'   => 'wpcf-data-cheltuielii',
    'orderby'    => 'meta_value_num',
    'order'      => 'asc',
    'posts_per_page'=> -1,
    'wp_like_post_title' => $_POST['keyword'],
    'meta_query' => array(
        'realtion' => 'AND',
        array(
            'key'     => 'wpcf-data-cheltuielii',
            'compare' => 'BETWEEN',
            'type'    => 'numeric',
            'value'   => Array($dela, $panala)

        ),

        array(
            'key'       => 'wpcf-categoria-'.get_current_user_id(),
            'value'     => $value_cat,
            'compare'   => $like_cat
        )
    ),

);
//the query
$the_query = new WP_Query($args);

?>
    <div class="page left">

        <?php
      // generating an array from wp results
        $table = Array();
        $tr = 0;
        while ($the_query->have_posts()) {
            $the_query->the_post();
            $table[$tr]['data_op'] = get_post_field('wpcf-data-cheltuielii', $post->ID);
            $table[$tr]['ora_reg'] = get_the_date('d-m-Y H:i', $post->ID);
            $table[$tr]['destinatia'] = get_the_title();
            $table[$tr]['categoria'] = get_post_meta($post->ID, "wpcf-categoria-".get_current_user_id(), true);
            $table[$tr]['beneficiar'] = get_post_meta($post->ID, "wpcf-beneficiar-".get_current_user_id(), true);
            $table[$tr]['suma'] = get_post_field('wpcf-suma', $post->ID);
            $table[$tr]['ch_id'] =$post->ID;
            $tr++;
        }

        /* Restore original Post Data */
        wp_reset_postdata();

//rendering the table
        echo "<table border='1' class='transactions' id='transactions'>";
        echo "<tr><th>Data tranzactiei</th><th>Data inregistrarii</th><th id='categoria'>Categoria</th><th field='destinatia'>Destinatia</th><th>Beneficiar</th><th id='suma'>Suma</th></tr>";
        $i = 0;
        $total_zi = 0;
        $total_sapt = 0;
        $total_perioada = 0;
        $days = Array('Duminica', 'Luni', 'Marti', 'Miercuri', 'Joi', 'Vineri', 'Sambata');

        $first_day = $table[0]['data_op'];
        $last_row = end($table);
        $last_day = $last_row['data_op'];

        for ($z = $first_day; $z <= $last_day; $z += 86400) {

            foreach ($table as $rows => $cel) {
                if ($z == $cel['data_op']) {
                    echo "<tr ch_id='".$cel['ch_id']."'>
        <td>" . date('d-m-Y', $cel['data_op']) . ", " . $days[date('w', $cel['data_op'])] . "</td>
        <td>" . $cel["ora_reg"] . "</td>
        <td>" . $cel["categoria"] . "</td>
        <td>" . $cel["destinatia"] . "</td>
        <td>" . $cel["beneficiar"] . "</td>
        <td class='sum'>" . number_format($cel["suma"], 2, '.', ' ')  . "</td>
        </tr>";
                    $i++;
                    if (date('d', $table[$i]['data_op']) !== date('d', $table[$i - 1]['data_op']) || !$table[$i]['data_op']) {
                        $total_zi = $total_zi + $cel['suma'];
                        $total_perioada = $total_perioada + $cel['suma'];
                        echo "<tr style='background: #ddd;'><td colspan='5'><b><i>Total pe ziua " . date('d-m-Y', $cel['data_op']) . "</i></b></td><td class='sum'><b><i>" . number_format($total_zi, 2, '.', ' ') . "</i></b></td></tr>";
                        $total_sapt = $total_sapt + $total_zi;
                        $total_zi = 0;
                    } else {
                        $total_zi = $total_zi + $cel['suma'];
                        $total_perioada = $total_perioada + $cel['suma'];
                    }
                }

            }
            if (date('w', $z) == '0' && !$total_sapt == 0 || $z == $last_day) {
                echo "<tr style='background: #FFC9FD'><td colspan='5'><b><i>Total saptamanal</i></b></td><td class='sum'><b><i>" . number_format($total_sapt, 2, '.', ' ') . "</i></b></td></tr>";
                $total_sapt = 0;
            }
        }
        echo "<tr style='background: #98D9BF'><td colspan='5'><b><i>Total perioada</i></b></td><td class='sum'><b><i>" . number_format($total_perioada, 2, '.', ' ') . "</i></b></td></tr>";
        echo "</table>";
        ?>
    </div>
    <div class="right sidebar">
        <?php
        get_sidebar();
        ?>
    </div>
<?php
get_footer();