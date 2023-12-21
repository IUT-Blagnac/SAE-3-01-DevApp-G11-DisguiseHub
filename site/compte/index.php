<html>

<head>
    <title>Mon compte - Disguise'Hub</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../css/general.css">
    <link rel="stylesheet" type="text/css" href="../css/compte/menuCompte.css">
    <script type="text/javascript" src="../include/fontawesome.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

    <?php
    session_start();
    if (!isset($_SESSION["connexion"])) {
        header("location: connexion.php");
        exit;
    }
    if (isset($_GET["deconnexion"])) {
        session_destroy();
        header("location: ../");
        exit;
    }
    if (isset($_GET["sesouvenir"])) {
        setcookie("sesouvenir", "", time() - 3600);
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }
    ?>

    <?php include("../include/header.php"); ?>

    <div class="content">
        <?php include("../include/menuCompte.php"); ?>

        <div>
            <h2>Mon compte</h2>
            <p>Page en construction...</p>
        </div>
    </div>

    <?php include("../include/footer.php"); ?>

</body>

</html>