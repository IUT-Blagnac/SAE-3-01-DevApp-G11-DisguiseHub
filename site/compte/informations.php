<?php

session_start();
if (!isset($_SESSION["connexion"])) {
    header("location: connexion.php");
    exit;
}

?>

<html>

<head>
    <title>Mes informations - Disguise'Hub</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../../css/general.css">
    <link rel="stylesheet" type="text/css" href="../../css/compte/menuCompte.css">
    <link rel="stylesheet" type="text/css" href="../../css/informations.css">
    <script type="text/javascript" src="../../include/fontawesome.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <?php include("../../include/header.php"); ?>

    <div class="content">
        <?php include("../../include/menuCompte.php"); ?>

        <div class="informations-container">
            <h2>Mes informations</h2><br><br>

            <?php
            require_once("../../include/connect.inc.php");

            $sql = "SELECT * FROM Client WHERE idClient = :id";
            $req = $conn->prepare($sql);
            $req->execute(["id" => $_SESSION["connexion"]]);
            $row = $req->fetch();
            ?>


            <form method="post" action="modification_informations.php">
                <?php if (!empty($row['nomClient'])) : ?>
                    <label>Nom : <?php echo $row['nomClient']; ?></label><br><br>
                <?php endif; ?>

                <?php if (!empty($row['prenomClient'])) : ?>
                    <label>Prénom : <?php echo $row['prenomClient']; ?></label><br><br>
                <?php endif; ?>

                <?php if (!empty($row['telClient'])) : ?>
                    <label>Téléphone : <?php echo $row['telClient']; ?></label><br><br>
                <?php endif; ?>

                <?php if (!empty($row['adresseClient'])) : ?>
                    <label>Adresse : <?php echo $row['adresseClient']; ?></label><br><br>
                <?php endif; ?>

                <?php if (!empty($row['codePostalClient'])) : ?>
                    <label>Code postal : <?php echo $row['codePostalClient']; ?></label><br><br>
                <?php endif; ?>

                <?php if (!empty($row['villeClient'])) : ?>
                    <label>Ville : <?php echo $row['villeClient']; ?></label><br><br>
                <?php endif; ?>

                <?php if (!empty($row['dateNaissanceClient'])) : ?>
                    <label>Date de naissance : <?php echo $row['dateNaissanceClient']; ?></label><br><br>
                <?php endif; ?>

                <?php if (!empty($row['mailClient'])) : ?>
                    <label>Email : <?php echo $row['mailClient']; ?></label><br><br>
                <?php endif; ?>

                <?php if (!empty($row['numCB'])) : ?>
                    <label>Carte Bleue : <?php echo $row['numCB']; ?></label><br><br>
                <?php endif; ?>

                <input type="submit" name="modifier_informations" value="Modifier">
            </form>

        </div>
    </div>

    <?php include("../../include/footer.php"); ?>
</body>

</html>