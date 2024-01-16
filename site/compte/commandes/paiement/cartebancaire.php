<html>

<head>
    <title>Paiement CB - Disguise'Hub</title>
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
                    // Récupérer la valeur du formulaire
                    $numCarte = $_POST["numCarte"];
                    $nomSurCB = $_POST["nomCarte"];
                    $dateExpCB = $_POST["dateExpiration"];
                    $parsedDate = date_parse_from_format("Y-m", $dateExpCB);
    
                    // Extraire le mois et l'année
                    $mois = sprintf("%02d", $parsedDate['month']); // Ajoute un zéro devant si le mois a un seul chiffre
                    $annee = substr($parsedDate['year'], -2); // Les deux derniers chiffres de l'année
    
                    // Concaténer le résultat au format souhaité
                    $dateExpCB = $mois . '/' . $annee;
                    $codeSecuriteCB = $_POST["Cryptogramme"];
    
                    $numCarte = substr($_POST["numCarte"], 0, 16);

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
                        // Vérifier si la carte bleue existe déjà dans la table Cartebleue
                        $sqlCheckCarte = "SELECT * FROM Cartebleue WHERE numCB = :numCarte";
                        $stmtCheckCarte = $conn->prepare($sqlCheckCarte);
                        $stmtCheckCarte->execute(["numCarte" => htmlspecialchars($numCarte)]);
        
                        // Si la carte bleue existe, récupérer son ID, sinon l'insérer dans la table Cartebleue
                        if ($row = $stmtCheckCarte->fetch()) {
                            $numCB = $row['numCB'];
                        } else {
                            // Insérer la carte bleue dans la table Cartebleue
                            $sqlInsertCarte = "INSERT INTO Cartebleue (numCB, nomSurCB, dateExpCB, codeSecuriteCB) VALUES (:numCarte, :nomSurCB, :dateExpCB, :codeSecuriteCB)";
                            $stmtInsertCarte = $conn->prepare($sqlInsertCarte);
                            $stmtInsertCarte->execute([
                                "numCarte" => htmlspecialchars($numCarte),
                                "nomSurCB" => htmlspecialchars($nomSurCB),
                                "dateExpCB" => htmlspecialchars($dateExpCB),
                                "codeSecuriteCB" => htmlspecialchars($codeSecuriteCB)
                            ]);
        
                            // Récupérer l'ID généré pour la carte bleue
                            $numCB = $conn->lastInsertId();
                        }

                        // Si mémoriser carte bleue
                        if (isset($_POST["sesouvenir"])) {
                            $sql = "UPDATE Client SET numCB = :numCB WHERE idClient = :idClient";
                            $req = $conn->prepare($sql);
                            $req->execute([
                                "numCB" => htmlspecialchars($numCB),
                                "idClient" => htmlspecialchars($_SESSION["connexion"])
                            ]);
                        }
        
                        // Préparer et exécuter la requête SQL pour insérer les données dans la base de données
                        $sql = "INSERT INTO Paiement (numCB) VALUES (:numCarte)";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute([
                            "numCarte" => htmlspecialchars($numCarte)
                        ]);
                        $idPaiement = $conn->lastInsertId();

                        // Ajout du paiement à la commande
                        $sql = "UPDATE Commande SET idPaiement = :idPaiement, statutCommande = :statut WHERE idCommande = :id";
                        $req = $conn->prepare($sql);
                        $req->execute([
                            "idPaiement" => htmlspecialchars($idPaiement),
                            "statut" => htmlspecialchars("En cours de préparation"),
                            "id" => htmlspecialchars($_POST["id"])]);
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
                        echo "<h2>Paiement CB - Commande " . $row["idCommande"] . "</h2>
                        
                        <form action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='POST'>
                            <input type='hidden' name='id' value='" . $_POST["id"] . "'>

                            <label>Nom</label>
                            <input type='text' name='nomCarte' required>
                
                            <label>Numéro</label>
                            <input type='tel' minlength='16' maxlength='16' pattern='[0-9\s]{13,25}' name='numCarte' autocomplete='cc-number' value='" . $cb . "' required>
                
                            <label>Date expiration</label>
                            <input type='month' name='dateExpiration' min='" . date("Y-m") . "' required>
                
                            <label>Cryptogramme</label>
                            <input type='tel' minlength='3' maxlength='4' pattern='[0-9\s]{3,4}' name='Cryptogramme' autocomplete='cc-csc' required>

                            <label class='checkbox'>
                                <input type='checkbox' name='souvenir'>
                                <svg width='20' height='20'>
                                    <polyline points='12 5 6.5 10.5 4 8'></polyline>
                                </svg>
                                Mémoriser ma carte bleue
                            </label>
                
                            <button type='submit' name='payer'>Payer " . number_format($row["montantTotal"], 2, ",", " ") . " €</button>
                            <a class='button' href='/~saephp11/compte/commandes/detail.php?id=" . $_POST["id"] . "&annuler'>Annuler</a>
                
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