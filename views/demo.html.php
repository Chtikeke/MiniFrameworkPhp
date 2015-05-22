<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8"/>
        <title>Demo bundle</title>
    </head>
    <body>
        <h1>Hello world</h1>
        <?php
            foreach ($users as $user) {
                echo '<p>' . $user->getName() . '</p>';
            }
        ?>
    </body>
</html>