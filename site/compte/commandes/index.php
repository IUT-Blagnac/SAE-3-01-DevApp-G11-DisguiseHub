<html>
    <head>
        <title>Mes commandes - Disguise'Hub</title>
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
        ?>
        
        <?php include("../../include/header.php"); ?>

        <div class="content">
            <?php include("../../include/menuCompte.php"); ?>

            <div>
                <h2>Mes commandes</h2>
                <?php
                    $sql = "SELECT * FROM Commande WHERE idClient = :id ORDER BY idCommande DESC";
                    $req = $conn->prepare($sql);
                    $req->execute(["id" => $_SESSION["connexion"]]);

                    if ($req->rowCount() == 0) {
                        echo "<p>Vous n'avez pas encore passé de commande.</p>";
                    } else {
                        echo "<table>
                            <tr class='head'>
                                <td>ID</td>
                                <td>Date</td>
                                <td>Montant</td>
                                <td>Statut</td>
                                <td>Paiement</td>
                                <td>Facture</td>
                            </tr>";
                        while ($row = $req->fetch()) {
                            echo "<tr>
                                <td>" . $row["idCommande"] . "</td>
                                <td>" . date("d/m/Y", strtotime($row["dateCommande"])) . "</td>
                                <td>" . number_format($row["montantTotal"], 2, ",", " ") . " €</td>
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
                                echo "<td><a href='/~saephp11/compte/commandes/detail.php?id=" . $row["idCommande"] . "'><i class='fas fa-file-invoice'></i> Ma facture</a></td>
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