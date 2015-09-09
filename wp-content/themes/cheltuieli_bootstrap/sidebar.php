<div id="sidebar">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Cautare</h3>
        </div>
        <div class="panel-body">
            <?php
            $custom_fields = get_option( 'wpcf-fields' );
            ?>
            <form action="<?php echo get_site_url()?>?page_id=8" method="post">
                <div class="form-group">
                    <label for="dela">De la</label>
                    <input  id="dela" type="text" name="dela" class="datepicker form-control" autocomplete="off" placeholder="Interval, de la...">
                </div>
                <div class="form-group">
                    <label for="panala">Pana la</label>
                    <input id="panala" type="text" name="panala" class="datepicker form-control" autocomplete="off" placeholder="Interval, pana la...">
                </div>
                <div class="form-group">
                    <label for="perioada">Perioada</label>
                    <select id="perioada" name="perioada" class="perioada form-control">
                        <option value="">Selecteaza perioada</option>
                        <option value="1">Ziua curenta</option>
                        <option value="2">Saptamana curenta</option>
                        <option value="3">Luna curenta</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="keyword">Dupa cuvant cheie</label>
                    <input id="keyword" type="text" name="keyword" placeholder="Cauta dupa cuvant cheie" class="keyword form-control">
                </div>
                <div class="form-group">
                    <a role="button" data-toggle="collapse" href="#lista_categorii_checkbox" aria-expanded="false" aria-controls="collapseExample">Dupa categorii</a>
                        <div class="collapse" id="lista_categorii_checkbox">
                            <div class="well">
                                <?php $categorii = get_user_option('settings', get_current_user_id());
                                foreach ($categorii['categories'] as $categorie){
                                    echo '<div class="checkbox"><label><input type="checkbox" name="categoria[]" value="'.$categorie.'">'.$categorie . '</label></div>';
                                } ?>
                                <a href="#" id="toggle_select_categories">Inverseaza selectia</a>
                            </div>
                        </div>

                </div>

                    <input type="submit" value="cauta" class="btn btn-default">
            </form>


        </div>
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">User Log Out</h3>
        </div>
        <div class="panel-body">
            <?php
            if ( is_user_logged_in() ) {
                echo "<a href='".wp_logout_url(home_url())."'>Log out</a>";
            }else{
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
            }


            ?>
        </div>
    </div>

</div>