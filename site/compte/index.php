<html>
    <head>
        <title>Disguise'Hub</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="../css/general.css">
        <link rel="stylesheet" type="text/css" href="../css/compte/compte.css">
        <script type="text/javascript" src="../include/fontawesome.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>

        <?php
            session_start();
            if(!isset($_SESSION["connexion"])){
                header("location: connexion.php");
                exit;
            }
        ?>
        
        <?php include("../include/header.php"); ?>

        <br>

        <?php include("../include/footer.php"); ?>

    </body>
</html>