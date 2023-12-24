<html>

<head>
    <title>Disguise'Hub</title>
    <link rel="apple-touch-icon" sizes="180x180" href="/~saephp11/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/~saephp11/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/~saephp11/img/favicon/favicon-16x16.png">
    <meta name="theme-color" content="#DE6E22">
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../../../css/general.css">
    <link rel="stylesheet" type="text/css" href="../../../css/compte/commandes/paiement/index.css">
    <script type="text/javascript" src="../../../include/fontawesome.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

    <?php include("../../../include/header.php"); ?>

    <?php
    if (isset($_POST["valider"])) {
        $destinataire = $_POST["nom"];
        $iban = $_POST["iban"];
        $bic = $_POST["bic"];
        $montant = $_POST["montant"];
        $dateVirement = $_POST["dateVirement"];

        // Insérer le virement dans la base de données
        $sql = "INSERT INTO VirementBancaire (destinataire, iban, bic, montant, dateVirement) VALUES (:destinataire, :iban, :bic, :montant, :dateVirement)";
        $stmt = $conn->prepare($sql);
        $stmt->execute(["destinataire" => htmlspecialchars($destinataire), "iban" => htmlspecialchars($iban), "bic" => htmlspecialchars($bic), "montant" => htmlspecialchars($montant), "dateVirement" => htmlspecialchars($dateVirement)]);

        if ($stmt) {
            echo "Virement enregistré avec succès.";
        } else {
            echo "Erreur lors de l'enregistrement du virement : " . $stmt->errorInfo()[2];
        }
    }

    ?>

    <div class="virement">

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">

            <h1>Virement bancaire</h1>

            <label for="nom">Destinataire</label>
            <input type="text" id="nom" name="nom" required>

            <label for="iban">IBAN</label>
            <input type="text" minlength="16" maxlength="33" id="iban" name="iban" pattern="[A-Z0-9]+" required>

            <label for="bic">BIC</label>
            <input type="text" id="bic" name="bic" pattern="[A-Z0-9]+" required>

            <label for="montant">Montant</label>
            <input type="text" id="montant" name="montant" pattern="\d+(\.\d{2})?" required step="0.01" />

            <label for="dateVirement">Date de virement</label>
            <input type="text" name="dateVirement" placeholder="YYYY-MM-DD" required>

            <button type="submit" name="valider" value="Valider">valider</button>
        </form>

    </div>

    < <?php include("../../../include/footer.php"); ?> 
    <script>
        document.getElementsByName("montant")[0].addEventListener("input", function() {

        this.value = this.value.replace(/[^0-9\.]/g, "");
        this.value = this.value.replace(/(\..*)\./g, "$1");

        });

    </script>
</body>

</html>