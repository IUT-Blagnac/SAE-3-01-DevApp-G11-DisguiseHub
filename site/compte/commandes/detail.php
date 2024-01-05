<html>
    <head>
        <?php echo "<title>Commande " . $_GET["id"] . " - Disguise'Hub</title>"; ?>
        <link rel="apple-touch-icon" sizes="180x180" href="/~saephp11/img/favicon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/~saephp11/img/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/~saephp11/img/favicon/favicon-16x16.png">
        <meta name="theme-color" content="#DE6E22">
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="../../css/general.css">
        <link rel="stylesheet" type="text/css" href="../../css/compte/menuCompte.css">
        <script type="text/javascript" src="../../include/fontawesome.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>

        <?php
            session_start();
            if(!isset($_SESSION["connexion"])) {
                header("location: ../connexion.php");
                exit;
            }
            if(!isset($_GET["id"])) {
                header("location: ./");
                exit;
            }
        ?>
        
        <?php include("../../include/header.php"); ?>

        <div class="content">
            <?php include("../../include/menuCompte.php"); ?>

            <div>
                <?php
                    $sql = "SELECT * FROM Commande WHERE idCommande = :id AND idClient = :idClient";
                    $req = $conn->prepare($sql);
                    $req->execute(["id" => $_GET["id"], "idClient" => $_SESSION["connexion"]]);
                    if ($req->rowCount() != 1) {
                        echo "<h2>Erreur</h2>
                        <p>Une erreur s'est produite.</p>
                        <a class='button' href='/~saephp11/compte/commandes'>Retourner à la liste des commandes</a>";
                    } else {
                        echo "<h2>Commande " . $_GET["id"] . "</h2>";
                        if (isset($_GET["succes"])) {
                            echo "<p>Votre paiement a bien été effectué.</p>";
                        }
                        echo "<table>
                            <tr class='head'>
                                <td>ID</td>
                                <td>Date</td>
                                <td>Montant</td>
                                <td>Frais de port</td>
                                <td>Statut</td>
                                <td>Paiement</td>
                            </tr>";
                        while ($row = $req->fetch()) {
                            echo "<tr>
                                <td>" . $row["idCommande"] . "</td>
                                <td>" . date("d/m/Y", strtotime($row["dateCommande"])) . "</td>
                                <td>" . number_format($row["montantTotal"], 2, ",", " ") . " €</td>
                                <td>" . number_format($row["fraisLivraison"], 2, ",", " ") . " €</td>
                                <td>" . $row["statutCommande"] . "</td>";
                                if (!$row["idPaiement"]) {
                                    echo "<td><a href='/~saephp11/compte/commandes/paiement/?id=" . $row["idCommande"] . "'><i class='fa-solid fa-money-bill-wave'></i> Procéder au paiement</a></td>";
                                } else {
                                    $sql = "SELECT * FROM Paiement WHERE idPaiement = :id";
                                    $req2 = $conn->prepare($sql);
                                    $req2->execute(["id" => $row["idPaiement"]]);
                                    $row2 = $req2->fetch();
                                    if ($row2["numCB"]) {
                                        echo "<td><i class='fas fa-credit-card'></i> Payé en CB</td>";
                                    } else if ($row2["idPaypal"]) {
                                        echo "<td><i class='fa-brands fa-cc-paypal'></i> Payé avec PayPal</td>";
                                    } else if ($row2["idVirement"]) {
                                        echo "<td><i class='fas fa-university'></i> Payé par virement</td>";
                                    } else if ($row2["idCheque"]) {
                                        echo "<td><i class='fa-solid fa-money-bill-wave'></i> Payé</td>";
                                    }
                                }
                            echo "</tr>";
                        }
                        echo "</table>
                        
                        <table>
                            <tr class='head'>
                                <td>Produit</td>
                                <td>Quantité</td>
                                <td>Prix</td>
                                <td>Total</td>
                            </tr>";
                        
                        $sql = "SELECT * FROM Commander WHERE idCommande = :id";
                        $req = $conn->prepare($sql);
                        $req->execute(["id" => $_GET["id"]]);
                        while ($row = $req->fetch()) {
                            $sql = "SELECT * FROM Produit WHERE refProduit = :id";
                            $req2 = $conn->prepare($sql);
                            $req2->execute(["id" => $row["refProduit"]]);
                            $row2 = $req2->fetch();
                            echo "<tr>
                                <td>" . $row2["nomProduit"] . "</td>
                                <td>" . $row["qteCommandee"] . "</td>
                                <td>" . number_format($row2["prixProduit"], 2, ",", " ") . " €</td>
                                <td>" . number_format($row["qteCommandee"] * $row2["prixProduit"], 2, ",", " ") . " €</td>
                            </tr>";
                        }
                        echo "</table>";
                    }
                ?>
            </div>
        </div>

        <?php include("../../include/footer.php"); ?>

    </body>
</html>