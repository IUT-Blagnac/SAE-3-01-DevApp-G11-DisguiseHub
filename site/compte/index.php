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
    <link rel="stylesheet" type="text/css" href="../css/compte/index.css">
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
            <h1>Mon compte</h1>

            <?php
                $sql = "SELECT fidelite FROM Client WHERE idClient = :id";
                $req = $conn->prepare($sql);
                $req->execute(["id" => htmlspecialchars($_SESSION["connexion"])]);
                $row = $req->fetch();
                $fidelite = $row["fidelite"];
                $progression = $fidelite % 10 * 10;
                if ($fidelite >= 10) {
                    $progression = 100;
                }
            ?>
            
            <div class="barre">
                <div class="progression" style = "width: <?php echo $progression ?>%;"><?php echo (($fidelite >= 1) ? $fidelite : "") ?></div>
            </div>
            <p>Vous avez actuellement <span><?php echo $fidelite ?> points de fidélité</span> ! Au bout de <span>10 points</span> vous recevrez <span>un avantage par email</span>.<br>
            <span>1 point = 10€ d'achat</span></p>
        </div>
    </div>


    <?php include("../include/footer.php"); ?>

</body>

</html>