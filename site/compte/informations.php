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
    <link rel="stylesheet" type="text/css" href="../css/general.css">
    <link rel="stylesheet" type="text/css" href="../css/compte/menuCompte.css">
    <link rel="stylesheet" type="text/css" href="../css/compte/informations.css">
    <script type="text/javascript" src="../include/fontawesome.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <?php include("../include/header.php"); ?>

    <div class="content">
        <?php include("../include/menuCompte.php"); ?>

        <div class="informations-container">
            <h2>Mes informations</h2><br>

            <?php
                $sql = "SELECT * FROM Client WHERE idClient = :id";
                $req = $conn->prepare($sql);
                $req->execute(["id" => $_SESSION["connexion"]]);
                $row = $req->fetch();
            ?>


            <form method="post" action="modification_informations.php">
                <?php if (!empty($row['nomClient'])) : ?>
                    <label>
                        <div class="label_titre">Nom : </div><br>
                        <div class="label_valeur"><?php echo $row['nomClient']; ?></div>
                    </label><br><br>
                <?php endif; ?>

                <?php if (!empty($row['prenomClient'])) : ?>
                    <label>
                        <div class=" label_titre">Prénom : </div><br>
                        <div class="label_valeur"><?php echo $row['prenomClient']; ?></div>
                    </label><br><br>
                <?php endif; ?>

                <?php if (!empty($row['telClient'])) : ?>
                    <label>
                        <div class="label_titre">Téléphone : </div><br>
                        <div class="label_valeur"><?php echo $row['telClient']; ?></div>
                    </label><br><br>
                <?php endif; ?>

                <?php if (!empty($row['adresseClient'])) : ?>
                    <label>
                        <div class="label_titre">Adresse : </div><br>
                        <div class="label_valeur"><?php echo $row['adresseClient']; ?></div>
                    </label><br><br>
                <?php endif; ?>

                <?php if (!empty($row['codePostalClient'])) : ?>
                    <label>
                        <div class="label_titre">Code postal : </div><br>
                        <div class="label_valeur"><?php echo $row['codePostalClient']; ?></div>
                    </label><br><br>
                <?php endif; ?>

                <?php if (!empty($row['villeClient'])) : ?>
                    <label>
                        <div class="label_titre">Ville : </div><br>
                        <div class="label_valeur"><?php echo $row['villeClient']; ?></div>
                    </label><br><br>
                <?php endif; ?>

                <?php if (!empty($row['dateNaissanceClient'])) : ?>
                    <label>
                        <div class="label_titre">Date de naissance : </div><br>
                        <div class="label_valeur"><?php echo $row['dateNaissanceClient']; ?></div>
                    </label><br><br>
                <?php endif; ?>

                <?php if (!empty($row['mailClient'])) : ?>
                    <label>
                        <div class="label_titre">Email : </div><br>
                        <div class="label_valeur"><?php echo $row['mailClient']; ?></div>
                    </label><br><br>
                <?php endif; ?>

                <?php if (!empty($row['numCB'])) : ?>
                    <label>
                        <div class="label_titre">Carte Bleue : </div><br>
                        <div class="label_valeur"><?php echo $row['numCB']; ?></div>
                    </label><br><br>
                <?php endif; ?>

                <input type="submit" name="modifier_informations" value="Modifier">

            </form>
            <form method="post" action="modification_mdp.php">
                <input type="submit" name="changer_mot_de_passe" value="Changer de mot de passe">
                <br>
            </form>

        </div>
    </div>

    <?php include("../include/footer.php"); ?>
</body>

</html>