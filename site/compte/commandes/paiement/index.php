<html>

    <head>
        <title>Paiement - Disguise'Hub</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="../../../css/general.css">
        <link rel="stylesheet" type="text/css" href="../../../css/compte/commandes/paiement/index.css">
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
                    $sql = "SELECT * FROM Commande WHERE idCommande = :id";
                    $req = $conn->prepare($sql);
                    $req->execute(["id" => $_POST["id"]]);
                    $row = $req->fetch();
                    
                    if ($req->rowCount() != 1 || $row["idClient"] != $_SESSION["connexion"] || $row["idPaiement"]) {
                        echo "<h2>Erreur</h2>
                        <p>Une erreur s'est produite.</p>
                        <a class='button' href='/~saephp11/compte/commandes'>Retourner à la liste des commandes</a>";
                    } else {
                        if (isset($_POST["carte"])) {
                            $sql = "INSERT INTO Paiement (numCB) VALUES (:numCB)";
                            $req = $conn->prepare($sql);
                            $req->execute(["numCB" => $_POST["numCB"]]);
                            $idPaiement = $conn->lastInsertId();
                        } else if (isset($_POST["paypal"])) {
                            $sql = "SELECT * FROM Paypal";
                            $req = $conn->prepare($sql);
                            $req->execute();
                            $idPaypal = $req->rowCount() + 1;

                            $sql = "INSERT INTO Paypal (idPaypal) VALUES (:idPaypal)";
                            $req = $conn->prepare($sql);
                            $req->execute(["idPaypal" => $idPaypal]);

                            $sql = "INSERT INTO Paiement (idPaypal) VALUES (:idPaypal)";
                            $req = $conn->prepare($sql);
                            $req->execute(["idPaypal" => $idPaypal]);
                            $idPaiement = $conn->lastInsertId();
                        } else if (isset($_POST["virement"])) {
                            $sql = "INSERT INTO Paiement (idVirement) VALUES (:idVirement)";
                            $req = $conn->prepare($sql);
                            $req->execute(["idVirement" => 1]);
                            $idPaiement = $conn->lastInsertId();
                        } else {
                            echo "<h2>Erreur</h2>
                            <p>Une erreur s'est produite.</p>
                            <a class='button' href='/~saephp11/compte/commandes'>Retourner à la liste des commandes</a>";
                        }
                        if (isset($idPaiement)) {
                            $sql = "UPDATE Commande SET idPaiement = :idPaiement WHERE idCommande = :id";
                            $req = $conn->prepare($sql);
                            $req->execute(["idPaiement" => $idPaiement, "id" => $_POST["id"]]);
                            echo "<h2>Paiement effectué</h2>
                            <p>Votre paiement a bien été effectué.</p>
                            <a class='button' href='/~saephp11/compte/commandes'>Retourner à la liste des commandes</a>";
                        }
                    }
                } else if (!isset($_GET["id"])) {
                    echo "<h2>Erreur</h2>
                    <p>Une erreur s'est produite.</p>
                    <a class='button' href='/~saephp11/compte/commandes'>Retourner à la liste des commandes</a>";
                } else {
                    $sql = "SELECT * FROM Commande WHERE idCommande = :id";
                    $req = $conn->prepare($sql);
                    $req->execute(["id" => $_GET["id"]]);
                    $row = $req->fetch();
                    if ($row["idClient"] != $_SESSION["connexion"] || $row["idPaiement"] || $req->rowCount() != 1) {
                        echo "<h2>Erreur</h2>
                        <p>Une erreur s'est produite.</p>
                        <a class='button' href='/~saephp11/compte/commandes'>Retourner à la liste des commandes</a>";
                    } else {
                        echo "<h2>Choisissez votre moyen de paiement</h2>
                        <p>Vous allez être redirigé vers le site de paiement sécurisé.</p>
    
                        <table>
                            <tr class='head'>
                                <td>ID</td>
                                <td>Montant</td>
                                <td>Facture</td>
                            </tr>
                            <tr>
                                <td>" . $row["idCommande"] . "</td>
                                <td>" . number_format($row["montantTotal"], 2, ",", " ") . " €</td>
                                <td><a href='/~saephp11/compte/commandes/facture.php?id=" . $row["idCommande"] . "'><i class='fas fa-file-invoice'></i> Ma facture</a></td>
                            </tr>
                        </table>
                        
                        <div>
                        <form action='cartebancaire.php' method='POST'>
                            <input type='hidden' name='id' value='" . $_GET["id"] . "'>
                                <button type='submit' name='carte' class='carte ignore'><i class='fa-solid fa-credit-card'></i> Carte bancaire</button>
                            </form>
                            <form action='paypal.php' method='POST'>
                                <input type='hidden' name='id' value='" . $_GET["id"] . "'>
                                <button type='submit' name='paypal' class='paypal ignore'><i class='fa-brands fa-cc-paypal'></i> Paypal</button>
                            </form>
                            <form action='virement.php' method='POST'>
                                <input type='hidden' name='id' value='" . $_GET["id"] . "'>
                                <button type='submit' name='virement' class='virement ignore'><i class='fa-solid fa-building-columns'></i> Virement</button>
                            </form>
                        </div>
                        <a href='/~saephp11/compte/commandes' class='button'>Retour</a>";
                    }
                }
            ?>

        </div>

        <?php include("../../../include/footer.php"); ?>


    </body>

</html>