<html>
    <head>
        <title>Mes avis - Disguise'Hub</title>
        <link rel="apple-touch-icon" sizes="180x180" href="/~saephp11/img/favicon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/~saephp11/img/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/~saephp11/img/favicon/favicon-16x16.png">
        <meta name="theme-color" content="#DE6E22">
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="../../css/general.css">
        <link rel="stylesheet" type="text/css" href="../../css/compte/menuCompte.css">
        <link rel="stylesheet" type="text/css" href="../../css/compte/avis/edit.css">
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
                <?php
                    $sql = "SELECT DISTINCT P.refProduit FROM Produit P, Commander Co, Commande C
                    WHERE P.refProduit = Co.refProduit
                    AND Co.idCommande = C.idCommande
                    AND C.idClient = :id
                    AND P.refProduit = :produit";
                    $req = $conn->prepare($sql);
                    $req->execute([
                        "id" => $_SESSION["connexion"],
                        "produit" => $_GET["id"]
                    ]);
                    if ($req->rowCount() == 0) {
                        echo "<h2>Erreur</h2>
                        <p>Vous ne pouvez pas laisser d'avis sur un produit que vous n'avez pas acheté.</p>
                        <a class='button' href='/~saephp11/compte/avis'>Retour</a>";
                    } else if ($req->rowCount() != 1) {
                        echo $req->rowCount();
                        echo "<h2>Erreur</h2>
                        <p>Une erreur est survenue.</p>
                        <a class='button' href='/~saephp11/compte/avis'>Retour</a>";
                    } else {
                        $sql = "SELECT DISTINCT P.refProduit FROM Produit P, Commander Co, Commande C
                        WHERE P.refProduit = Co.refProduit
                        AND Co.idCommande = C.idCommande
                        AND C.idClient = :id
                        AND P.refProduit = :produit
                        AND P.refProduit NOT IN (
                            SELECT refProduit FROM Avis A
                            WHERE A.idClient = C.idClient
                        )";
                        $req = $conn->prepare($sql);
                        $req->execute([
                            "id" => $_SESSION["connexion"],
                            "produit" => $_GET["id"]
                        ]);
                        if (isset($_GET["supprimer"])) {
                            $status = "supprimer";
                            echo "<h2>Supprimer un avis</h2>";
                        } else if ($req->rowCount() == 0) {
                            $status = "modifier";
                            echo "<h2>Modifier un avis</h2>";
                        } else {
                            $status = "ajouter";
                            echo "<h2>Ajouter un avis</h2>";
                        }
                        $sql = "SELECT * FROM Produit WHERE refProduit = :id";
                        $req = $conn->prepare($sql);
                        $req->execute(["id" => $_GET["id"]]);
                        $produit = $req->fetch();
                        $sql = "SELECT * FROM Avis WHERE idClient = :id AND refProduit = :produit";
                        $req = $conn->prepare($sql);
                        $req->execute([
                            "id" => $_SESSION["connexion"],
                            "produit" => $_GET["id"]
                        ]);
                        $avi = $req->fetch();

                        echo "<div class='avis'>
                            <form class='avi' action='edit.php' method='POST' enctype='multipart/form-data'>
                                <div>
                                    <div class='inputs'>
                                        <div class='note'>
                                            <label for='note'>Note :</label>
                                            <select name='note' required>
                                                <option selected disabled></option>";
                                                for ($i = 1; $i <= 5; $i++) {
                                                    echo "<option value='" . $i . "' " . (isset($avi["note"]) ? "selected" : "") . ">";
                                                    for ($j = 0; $j < $i; $j++) {
                                                        echo "⭐";
                                                    }
                                                    echo "</option>";
                                                }
                                            echo "</select>
                                        </div>
                                        <div class='texte'>
                                            <label for='commentaire'>Commentaire :</label>
                                            <textarea name='commentaire' value='" . $avi["note"] . "' required>" . $avi["commentaire"] . "</textarea>
                                        </div>
                                    </div>
                                    <div class='image'>";
                                        if (isset($avi["imageAvis"])) {
                                            echo "<img src='" . $avi["imageAvis"] . "' alt='Votre image d'avis'>";
                                        }
                                        echo "<label>
                                            <input type='file' name='image' style='display: none;' id='image' accept='image/*'>";
                                            if (isset($avi["imageAvis"])) {
                                                echo "<i class='fa fa-cloud-upload'></i> Mettre à jour l'image";
                                            } else {
                                                echo "<i class='fa fa-cloud-upload'></i> Ajouter une image";
                                            }
                                        echo "</label>
                                    </div>
                                </div>
                                <div>
                                    <a class='button retour' href='/~saephp11/compte/avis'>Retour</a>";
                                    if ($status == "modifier") {
                                        echo "<a class='button supprimer' href='/~saephp11/compte/avis/edit.php?id=" . $_GET["id"] . "&supprimer'>Supprimer</a>";
                                    }
                                    echo "<button type='submit'>Valider</button>
                                </div>
                            </form>";
                            require_once("../../include/apercuProduit.php");
                        echo "</div>";
                    }
                ?>
            </div>
        </div>

        <?php include("../../include/footer.php"); ?>

    </body>
</html>