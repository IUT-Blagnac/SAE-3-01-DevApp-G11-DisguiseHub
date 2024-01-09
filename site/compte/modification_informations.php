<?php
session_start();
if (!isset($_SESSION["connexion"])) {
    header("location: connexion.php");
    exit;
}
?>

<html>

<head>
    <title>Modification des informations - Disguise'Hub</title>
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
    <?php include("../include/header.php"); ?>

    <div class="content">
        <?php include("../include/menuCompte.php"); ?>

        <?php

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["modifier_informations"])) {
            if (
                isset($_POST["new_nom"]) && isset($_POST["new_prenom"]) &&
                isset($_POST["new_tel"]) && isset($_POST["new_adresse"]) &&
                isset($_POST["new_codePostal"]) && isset($_POST["new_ville"]) &&
                isset($_POST["new_dateNaissance"]) && isset($_POST["new_email"])
            ) {
                $newCodePostal = $_POST["new_codePostal"];
                $newDateNaissance = !empty($_POST["new_dateNaissance"]) ? $_POST["new_dateNaissance"] : null;

                if (empty($newCodePostal)) {
                    $newCodePostal = null;
                }

                $numCB = $_POST["new_cb"];

                if (empty($new_cb)) {
                    $sqlSupCarteBleue = "DELETE FROM Cartebleue WHERE nomSurCB = :nomSurCB";
                    $sqlSupClientCB = "UPDATE Client SET numCB = NULL WHERE idClient = :id";
                    $reqSupClientCB = $conn->prepare($sqlSupClientCB);
                    $reqSupCarteBleue = $conn->prepare($sqlSupCarteBleue);
                    $reqSupCarteBleue->bindParam(':nomSurCB', $_POST["new_nom"]);
                    $reqSupClientCB->bindParam(':id', $_SESSION["connexion"]);
                    $reqSupClientCB->execute();
                    $reqSupCarteBleue->execute();
                }


                $sqlCarteBleue = "SELECT * FROM Cartebleue WHERE numCB = :numCB";
                $reqCarteBleue = $conn->prepare($sqlCarteBleue);
                $reqCarteBleue->bindParam(':numCB', $numCB);
                $reqCarteBleue->execute();

                if ($reqCarteBleue->rowCount() == 0) {
                    $sqlInsertCarteBleue = "INSERT INTO Cartebleue (numCB, nomSurCB) VALUES (:numCB, :nomSurCB)";
                    $reqInsertCarteBleue = $conn->prepare($sqlInsertCarteBleue);
                    $reqInsertCarteBleue->bindParam(':numCB', $numCB);
                    $reqInsertCarteBleue->bindParam(':nomSurCB', $_POST["new_nom"]);
                    $reqInsertCarteBleue->execute();
                }

                $sqlUpd = "UPDATE Client 
                               SET nomClient = :new_nom, prenomClient = :new_prenom, 
                                   adresseClient = :new_adresse, mailClient = :new_mail, 
                                   codePostalClient = :new_codePostal, villeClient = :new_ville, 
                                   dateNaissanceClient = :new_dateNaissance, telClient = :new_tel,
                                   numCB = :new_cb
                               WHERE idClient = :id";

                $reqUpd = $conn->prepare($sqlUpd);

                $reqUpd->bindParam(':new_nom', $_POST["new_nom"]);
                $reqUpd->bindParam(':new_prenom', $_POST["new_prenom"]);
                $reqUpd->bindParam(':new_adresse', $_POST["new_adresse"]);
                $reqUpd->bindParam(':new_mail', $_POST["new_email"]);
                $reqUpd->bindParam(':new_codePostal', $newCodePostal, PDO::PARAM_INT);
                $reqUpd->bindParam(':new_ville', $_POST["new_ville"]);
                $reqUpd->bindParam(':new_dateNaissance', $newDateNaissance, PDO::PARAM_STR);
                $reqUpd->bindParam(':new_tel', $_POST["new_tel"]);
                $reqUpd->bindParam(':new_cb', $numCB);
                $reqUpd->bindParam(':id', $_SESSION["connexion"]);

                if ($reqUpd->execute()) {

                    echo "<script>
                            var conf = confirm('Vos informations ont été modifiées avec succès. Cliquez sur OK pour revenir à la page d\'informations.');
                            if (conf) {
                                window.location = 'informations.php';
                            } else {
                                window.location = 'informations.php';
                            }
                        </script>";
                    exit;
                }
            }
        }

        $sql = "SELECT * FROM Client WHERE idClient = :id";
        $req = $conn->prepare($sql);
        $req->execute(["id" => $_SESSION["connexion"]]);
        $row = $req->fetch();
        ?>

        <div class="informations-container">
            <div class="modif_info_content">
                <h2>Modification des informations</h2><br><br>

                <form method="post" action="modification_informations.php">
                    <label>Nom : </label>
                    <input type="text" name="new_nom" value="<?php echo $row['nomClient']; ?>" required>
                    <br><br>
                    <label>Prénom : </label>
                    <input type="text" name="new_prenom" value="<?php echo $row['prenomClient']; ?>" required>
                    <br><br>
                    <label>Téléphone : </label>
                    <input type="text" name="new_tel" value="<?php echo $row['telClient']; ?>" required>
                    <br><br>
                    <label>Adresse : </label>
                    <input type="text" name="new_adresse" value="<?php echo $row['adresseClient']; ?>">
                    <br><br>
                    <label>Code postal : </label>
                    <input type="text" name="new_codePostal" value="<?php echo $row['codePostalClient']; ?>">
                    <br><br>
                    <label>Ville : </label>
                    <input type="text" name="new_ville" value="<?php echo $row['villeClient']; ?>">
                    <br><br>
                    <label>Date de naissance : </label>
                    <input type="date" name="new_dateNaissance" value="<?php echo $row['dateNaissanceClient']; ?>">
                    <br><br>
                    <label>Email : </label>
                    <input type="email" name="new_email" value="<?php echo $row['mailClient']; ?>" required>
                    <br><br>
                    <?php
                    $cbDejaEnregistree = !empty($row['numCB']);
                    ?>
                    <?php if (!$cbDejaEnregistree) : ?>
                        <label for="new_cb">Carte Bleue : </label>
                        <input type="text" name="new_cb" id="new_cb" style="display: none;" value="<?php echo $row['numCB']; ?>">
                        <br>
                        <input type="button" id="enregistrer_cb_btn" value="Enregistrer une CB">
                        <br>
                    <?php endif; ?>
                    <?php if ($cbDejaEnregistree) : ?>
                        <label for="new_cb">Carte Bleue : </label>
                        <input type="text" name="new_cb" id="new_cb" value="<?php echo $row['numCB']; ?>">
                        <br><br>
                    <?php endif; ?>
                    <input type="submit" name="modifier_informations" value="Valider">
                </form>
                <script>
                    document.getElementById('enregistrer_cb_btn').addEventListener('click', function() {
                        document.getElementById('new_cb').style.display = 'block';
                    });
                </script>
            </div>
        </div>
    </div>

    <?php include("../include/footer.php"); ?>
</body>

</html>