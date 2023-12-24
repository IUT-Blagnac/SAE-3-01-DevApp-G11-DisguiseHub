<html>
<head>
    <title>Mon compte - Disguise'Hub</title>
    <link rel="apple-touch-icon" sizes="180x180" href="/~saephp11/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/~saephp11/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/~saephp11/img/favicon/favicon-16x16.png">
    <meta name="theme-color" content="#DE6E22">
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../css/general.css">
    <link rel="stylesheet" type="text/css" href="../css/compte/menuCompte.css">
    <link rel="stylesheet" type="text/css" href="../css/compte/modification_informations.css">
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

        <div class="compte_content">
            <h1>Bonjour</h1> <br>
            <div class="box">
                <p>Vous pouvez consulter l'historique de vos demandes et gérer vos données personnelles dans votre compte client. Choisissez un des liens dans le menu de gauche pour accéder aux informations ou les modifier</p>
            </div>
            <br><br><br>
            <div class="centrer">
                <h2>Pour accéder à mon panier : </h2><br><br>
                <a href="../panier.php"><button class="button">Mon panier</button></a><br><br><br>
                <h2>Pour accéder à mes commandes : </h2><br><br>
                <a href="../compte/commandes/index.php"><button class="button">Mes commandes</button></a><br>
            </div>
        </div>
    </div>


    <?php include("../include/footer.php"); ?>

</body>

</html>