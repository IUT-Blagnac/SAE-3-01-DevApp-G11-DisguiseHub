<html>

<head>
    <title>Disguise'Hub</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../../../css/general.css">
    <link rel="stylesheet" type="text/css" href="../../../css/compte/commandes/paiement/index.css">
    <script type="text/javascript" src="../../../include/fontawesome.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <?php include("../../../include/header.php"); ?>

    <?php
    // Vérifier si le formulaire a été soumis
    if (isset($_POST["valider"])) {
        // Récupérer la valeur du formulaire
        $numCarte = $_POST["numCarte"];

        $numCarte = substr($_POST["numCarte"], 0, 16);
        // Préparer et exécuter la requête SQL pour insérer les données dans la base de données
        $sql = "INSERT INTO Paiement (numCB) VALUES (:numCarte)";

        $stmt = $conn->prepare($sql);
        $succes = $stmt->execute(["numCarte" => htmlspecialchars($numCarte)]);
    }

    ?>

    <div class="Paiement">

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">

            <h1>Paiement</h1>

            <label class="subtitle"><b>Nom du titulaire</b></label>
            <input type="text" placeholder="Entrer le nom du titulaire de la carte" name="nomCarte">

            <label class="subtitle"><b>Numéro de la carte</b></label>
            <input type="tel" minlength="16" maxlength="16" pattern="[0-9\s]{13,25}" title="numCarte" name="numCarte" autocomplete="cc-number" placeholder="XXXXXXXXXXXXXXXX" required />

            <label class="subtitle"><b>Date expiration</b></label>
            <input type="month" name="dateExpiration">

            <label class="subtitle"><b>Cryptogramme</b></label>
            <input type="text" minlength="3" maxlength="3" pattern="[0-9]" title="Cryptogramme" name="Cryptogramme">

            <button type="submit" name="valider" value="Valider">valider</button>

        </form>

    </div>

    <?php include("../../../include/footer.php"); ?>

    <script>
        document.getElementsByName("numCarte")[0].addEventListener("input", function() {

            this.value = this.value.replace(/[^0-9]/g, "");

        });
    </script>

</body>

</html>