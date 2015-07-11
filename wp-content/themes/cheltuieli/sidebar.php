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
                        $categorii = $custom_fields['categoria']['data']['options'];
                        foreach ($categorii as $categorie){
                            echo '<input type="checkbox" name="categoria[]" value="'.$categorie['value'].'">'.$categorie['title'].'</option>'."<br/>";
                        }
                        ?>
<!--                    </select>-->
                </td>
            </tr>
        </table>
        <input type="submit" value="cauta">
    </form>

<!--    <h2 >--><?php //_e('Categories'); ?><!--</h2>-->
<!--    <ul >-->
<!--        --><?php //wp_list_categories('sort_column=name&optioncount=1&hierarchical=0'); ?>
<!--    </ul>-->
<!--    <h2 >--><?php //_e('Archives'); ?><!--</h2>-->
<!--    <ul >-->
<!--        --><?php //wp_get_archives('type=monthly'); ?>
<!--    </ul>-->
</div>