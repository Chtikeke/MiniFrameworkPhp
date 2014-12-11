<html>
    <?php include 'partials/header.html.php'; ?>
<body>
    <?php include 'partials/menu.html.php'; ?>
    <h1><?= isset($parameters['titre']) ? $parameters['titre'] : 'Titre par défaut'; ?></h1>
</body>
</html>