<div id="sidebar">
    <h2>Cautare:</h2>
    <?php
    $custom_fields = get_option( 'wpcf-fields' );
    ?>
    <form action="<?php echo get_site_url()?>?page_id=8" method="post">
        <table>
            <tr>
                <td>Data:</td>
                <td>
                    <input type="text" name="dela" class="datepicker" autocomplete="off">
                    <input type="text" name="panala" class="datepicker" autocomplete="off">
                </td>
            </tr>
            <tr>
                <td>Perioada: </td>
                <td>
                    <select name="perioada" class="perioada">
                        <option value="">Selecteaza perioada</option>
                        <option value="1">Ziua curenta</option>
                        <option value="2">Saptamana curenta</option>
                        <option value="3">Luna curenta</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Ceva concret:</td>
                <td><input type="text" name="keyword" placeholder="Cauta dupa cuvant cheie" class="keyword"></td>
            </tr>
            <tr>
                <td>Categoria</td>
                <td>
<!--                    <select name="categoria" class="search categoria">-->
<!--                        <option value="0" selected>Selecteaza categoria</option>-->
                        <?php
                        $categorii = get_user_option('settings', get_current_user_id());
                        foreach ($categorii['categories'] as $categorie){
                            echo '<input type="checkbox" name="categoria[]" value="'.$categorie.'">'.$categorie.'</option>'."<br/>";
                        }
                        ?>
<!--                    </select>-->
                </td>
            </tr>
        </table>
        <input type="submit" value="cauta">
    </form>

<?php
$args = array(
    'echo'           => true,
    'redirect' => ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
    'form_id'        => 'loginform',
    'label_username' => __( 'Username' ),
    'label_password' => __( 'Password' ),
    'label_remember' => __( 'Remember Me' ),
    'label_log_in'   => __( 'Log In' ),
    'id_username'    => 'user_login',
    'id_password'    => 'user_pass',
    'id_remember'    => 'rememberme',
    'id_submit'      => 'wp-submit',
    'remember'       => true,
    'value_username' => '',
    'value_remember' => false
);
wp_login_form( $args );

?>
</div>