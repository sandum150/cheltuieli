
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Restrict Access</title>
    <?
    wp_head();
    ?>
</head>
<body class="restrict_access_body">

<div class="restrict_access_container">

    <form method="post" autocomplete="off">

        <p>Esti de-a nostru?</p>

        <input type="text" class="username" autocomplete="off" name="email" placeholder="username...">

        <input type="password" class="password" autocomplete="off" name="password"  placeholder="password...">

        <input type="submit" value="Login" name="restrict_access_submit">

            <?php
                $errors = restrict_access_get();

            if(is_wp_error($errors)){

                $error_string = strtok($errors->get_error_message(), '.');
                echo '<p class="error">' . $error_string . '</p>';

            }

            ?>

    </form>

</div>

<?
wp_footer();
?>
</body>
</html>