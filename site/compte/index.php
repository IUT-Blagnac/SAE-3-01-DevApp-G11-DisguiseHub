<html>
    <head>
        <title>Disguise'Hub</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="../css/general.css">
        <link rel="stylesheet" type="text/css" href="../css/compte/menuCompte.css">
        <link rel="stylesheet" type="text/css" href="../css/compte/compte.css">
        <script type="text/javascript" src="../include/fontawesome.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>

        <?php
            if (isset($_GET["deconnexion"])) {
                session_start();
                session_destroy();
                header("location: ../");
                exit;
            }
        ?>
        
        <?php include("../include/header.php"); ?>

        <div class="content">
            <?php include("../include/menuCompte.php"); ?>

            <div>
                <h2>Mon compte</h2>
            </div>
        </div>

        <?php include("../include/footer.php"); ?>

    </body>
</html>