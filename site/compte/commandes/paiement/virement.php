<html>

<head>
    <title>Paiement virement - Disguise'Hub</title>
    <link rel="apple-touch-icon" sizes="180x180" href="/~saephp11/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/~saephp11/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/~saephp11/img/favicon/favicon-16x16.png">
    <meta name="theme-color" content="#DE6E22">
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../../../css/general.css">
    <link rel="stylesheet" type="text/css" href="../../../css/compte/commandes/paiement/cartebleue-virement.css">
    <script type="text/javascript" src="../../../include/fontawesome.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <?php
        session_start();
    ?>

    <?php include("../../../include/header.php"); ?>

    <div class="content">

        <?php
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                if (isset($_POST["payer"])) {
                    $destinataire = $_POST["nom"];
                    $iban = $_POST["iban"];
                    $bic = $_POST["bic"];

                    // Obtenir la commande
                    $sqlGetCommande = "SELECT * FROM Commande WHERE idCommande = :id AND idClient = :idClient AND idPaiement IS NULL";
                    $stmtGetCommande = $conn->prepare($sqlGetCommande);
                    $stmtGetCommande->execute([
                        "id" => htmlspecialchars($_POST["id"]),
                        "idClient" => htmlspecialchars($_SESSION["connexion"])
                    ]);
                    $rowCommande = $stmtGetCommande->fetch();

                    if ($stmtGetCommande->rowCount() != 1) {
                        echo "<h2>Erreur</h2>
                        <p>Une erreur s'est produite lors du paiement. Aucun débit n'a été effectué.</p>
                        <a class='button' href='/~saephp11/compte/commandes'>Retourner à la liste des commandes</a>";
                    } else {
                        // Insérer le virement dans la base de données
                        $sql = "INSERT INTO VirementBancaire (destinataire, iban, bic, montant, dateVirement) VALUES (:destinataire, :iban, :bic, :montant, :dateVirement)";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute([
                            "destinataire" => htmlspecialchars($destinataire),
                            "iban" => htmlspecialchars($iban),
                            "bic" => htmlspecialchars($bic),
                            "montant" => $rowCommande["montantTotal"],
                            "dateVirement" => date("Y-m-d")
                        ]);
                        $idVirement = $conn->lastInsertId();
        
                        // Insérer paiement
                        $sql = "INSERT INTO Paiement (idVirement) VALUES (:idVirement)";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute([
                            "idVirement" => $idVirement
                        ]);
                        $idPaiement = $conn->lastInsertId();

                        // Ajout du paiement à la commande
                        $sql = "UPDATE Commande SET idPaiement = :idPaiement, statutCommande = :statut WHERE idCommande = :id";
                        $req = $conn->prepare($sql);
                        $req->execute([
                            "idPaiement" => $idPaiement,
                            "statut" => "En cours de préparation",
                            "id" => $_POST["id"]]);
                        header("Location: ./?succes=" . $_POST["id"]);
                        exit();
                    }
                } else if (isset($_POST["id"]) && isset($_SESSION["connexion"])) {
                    $sql = "SELECT * FROM Commande WHERE idCommande = :id AND idClient = :idClient AND idPaiement IS NULL";
                    $req = $conn->prepare($sql);
                    $req->execute([
                        "id" => htmlspecialchars($_POST["id"]),
                        "idClient" => htmlspecialchars($_SESSION["connexion"])
                    ]);
                    if ($req->rowCount() != 1) {
                        echo "<h2>Erreur</h2>
                        <p>Une erreur s'est produite.</p>
                        <a class='button' href='/~saephp11/compte/commandes'>Retourner à la liste des commandes</a>";
                    } else {
                        $row = $req->fetch();
                        $sql = "SELECT numCB FROM Client WHERE idClient = :idClient";
                        $req = $conn->prepare($sql);
                        $req->execute(["idClient" => htmlspecialchars($_SESSION["connexion"])]);
                        $cb = $req->fetch()["numCB"];
                        echo "<h2>Paiement Virement - Commande " . $row["idCommande"] . "</h2>
                        
                        <form action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='POST'>
                            <input type='hidden' name='id' value='" . $_POST["id"] . "'>

                            <label>Nom</label>
                            <input type='text' name='nom' required>
                
                            <label>IBAN</label>
                            <input type='text' minlength='16' maxlength='33' name='iban' pattern='[A-Z0-9]+' required>

                            <label>BIC</label>
                            <input type='text' name='bic' pattern='[A-Z0-9]+' required>
                
                            <button type='submit' name='payer'>Payer " . number_format($row["montantTotal"], 2, ",", " ") . " €</button>
                            <a class='button' href='/~saephp11/compte/commandes/detail.php?id=" . $_POST["id"] . "'>Annuler</a>
                
                        </form>";
                    }
                } else {
                    echo "<h2>Erreur</h2>
                    <p>Une erreur s'est produite.</p>
                    <a class='button' href='/~saephp11/compte/commandes'>Retourner à la liste des commandes</a>";
                }
            } else {
                echo "<h2>Erreur</h2>
                <p>Une erreur s'est produite.</p>
                <a class='button' href='/~saephp11/compte/commandes'>Retourner à la liste des commandes</a>";
            }
        ?>

    </div>

    <?php include("../../../include/footer.php"); ?>

</body>

</html>