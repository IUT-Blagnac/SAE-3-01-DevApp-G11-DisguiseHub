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
        <link rel="stylesheet" type="text/css" href="../../css/compte/avis/index.css">
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
                <h2>Mes avis</h2>
                <div class="avis">
                <?php
                    $sql = "SELECT * FROM Avis WHERE idClient = :id ORDER BY idAvis DESC";
                    $avis = $conn->prepare($sql);
                    $avis->execute(["id" => $_SESSION["connexion"]]);

                    if ($avis->rowCount() == 0) {
                        echo "<p>Vous n'avez pas laissé d'avis.</p>";
                    } else {
                        while ($avi = $avis->fetch()) {
                            $sql = "SELECT * FROM Produit WHERE refProduit = :id";
                            $req = $conn->prepare($sql);
                            $req->execute(["id" => $avi["refProduit"]]);
                            $produit = $req->fetch();
                            $sql = "SELECT * FROM Avis WHERE idAvisPere = :id";
                            $req = $conn->prepare($sql);
                            $req->execute(["id" => $avi["idAvis"]]);
                            $reponse = $req->fetch();

                            echo "<div class='avi'>
                                <div class='texte'>
                                    <div class='client'>
                                        <div class='note'>";
                                            for ($i = 0; $i < $avi["note"]; $i++) {
                                                echo "<i class='fas fa-star color'></i>";
                                            }
                                            for ($i = 0; $i < 5 - $avi["note"]; $i++) {
                                                echo "<i class='fas fa-star'></i>";
                                            }
                                        echo "</div>
                                        <h3><a href='/~saephp11/produit.php?id=" . $produit["refProduit"] . "'>" . $produit["nomProduit"] . "</a></h3>
                                    </div>
                                    <p>" . $avi["commentaire"] . "</p>";
                                    if (isset($reponse["commentaire"])) {
                                        echo "<h4>Disguise'Hub</h4>
                                        <p>" . $reponse["commentaire"] . "</p>";
                                    }
                                    echo "<div class='buttons'>
                                        <a class='button' href='/~saephp11/compte/avis/edit.php?id=" . $produit["refProduit"] . "'>Modifier</a>
                                        <a class='button' href='/~saephp11/compte/avis/edit.php?id=" . $produit["refProduit"] . "&supprimer'>Supprimer</a>
                                    </div>
                                </div>";
                                if (isset($avi["imageAvis"])) {
                                    echo "<img src='" . $avi["imageAvis"] . "' alt='Photo de l'avis " . $avi["idAvis"] . "'>";
                                }
                            echo "</div>";
                        }
                    }
                ?>
                </div>
                <?php
                    $sql = "SELECT DISTINCT P.refProduit, P.nomProduit FROM Produit P, Commander Co, Commande C
                    WHERE P.refProduit = Co.refProduit
                    AND Co.idCommande = C.idCommande
                    AND C.idClient = :id
                    AND P.refProduit NOT IN (
                        SELECT refProduit FROM Avis A
                        WHERE A.idClient = C.idClient
                    )";
                    $req = $conn->prepare($sql);
                    $req->execute(["id" => $_SESSION["connexion"]]);
                    if ($req->rowCount() != 0) {
                        echo "<form action='edit.php' method='GET'>
                            <select name='id' required>
                                <option value='' selected disabled>Choisissez un produit</option>";
                                while ($produit = $req->fetch()) {
                                    echo "<option value='" . $produit["refProduit"] . "'>" . $produit["nomProduit"] . "</option>";
                                }
                            echo "</select>
                            <button type='submit'>Ajouter un avis</button>
                        </form>";
                    }
                ?>
            </div>
        </div>

        <?php include("../../include/footer.php"); ?>

    </body>
</html>