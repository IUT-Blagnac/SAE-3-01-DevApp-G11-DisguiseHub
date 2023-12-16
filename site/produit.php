<html>

<head>
    <title>Produit - Disguise'Hub</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="./css/general.css">
    <link rel="stylesheet" type="text/css" href="./css/produit.css">
    <script type="text/javascript" src="./include/fontawesome.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

    <?php include("include/header.php"); ?>

    <div class="content">

        <?php
            // Si aucun produit n'est spécifié
            if (empty($_GET["id"])) {
                header("Location: ./");
            } else {
                $sql = "SELECT * FROM Produit WHERE refProduit = :ref";
                $req = $conn -> prepare($sql);
                $req -> execute(["ref" => $_GET["id"]]);
                
                // Cas d'erreurs
                if ($req && $req->rowCount() > 1) {
                    echo "<h1>Erreur</h1>
                    <p>Plusieurs correspondaces ont été trouvées pour le produit \"" . $_GET["id"] . "\".</p>
                    <a href='./' class='button'>Retour à l'accueil</a>";
                } else if ($req && $req->rowCount() == 0) {
                    echo "<h1>Produit introuvable</h1>
                    <p>Le produit \"" . $_GET["id"] . "\" n'existe pas.</p>
                    <a href='./' class='button'>Retour à l'accueil</a>";
                } else {
                    $produit = $req -> fetch();

                    echo "<script type='text/javascript'>
                        document.title = '" . $produit["nomProduit"] . " - Disguise\'Hub'
                    </script>";

                    /* A RETIRER QUAND LA TABLE ASSOPRODUITCATEG SERA REMPLIE */
                    $sql = "SELECT * FROM Categorie WHERE idCategorie = :cat";
                    $req = $conn -> prepare($sql);
                    $req -> execute(["cat" => $produit["idCategorie"]]);
                    $categorie = $req -> fetch();

                    if (isset($categorie["idCategoriePere"])) {
                        $sql = "SELECT * FROM Categorie WHERE idCategorie = :cat";
                        $req = $conn -> prepare($sql);
                        $req -> execute(["cat" => $categorie["idCategoriePere"]]);
                        $categoriePere = $req -> fetch();
                    }
                    /* A RETIRER QUAND LA TABLE ASSOPRODUITCATEG SERA REMPLIE */

                    $sql = "SELECT * FROM AssoProduitCateg WHERE refProduit = :ref";
                    $req = $conn -> prepare($sql);
                    $req -> execute(["ref" => $_GET["id"]]);
                    $categories = $req -> fetchAll();

                    $sql = "SELECT * FROM Image WHERE refProduit = :ref";
                    $req = $conn -> prepare($sql);
                    $req -> execute(["ref" => $_GET["id"]]);
                    $images = $req -> fetchAll();

                    $sql = "SELECT * FROM Avis WHERE refProduit = :ref";
                    $req = $conn -> prepare($sql);
                    $req -> execute(["ref" => $_GET["id"]]);
                    $avis = $req -> fetchAll();

                    if (count($avis) != 0) {
                        $sql = "SELECT AVG(note) AS moyenne FROM Avis WHERE refProduit = :ref";
                        $req = $conn -> prepare($sql);
                        $req -> execute(["ref" => $_GET["id"]]);
                        $moyenne = round($req -> fetch()["moyenne"]);
                    }

                    /* A RETIRER QUAND LA TABLE ASSOPRODUITCATEG SERA REMPLIE */
                    echo "<div class='categoriesold'>";
                        if (isset($categoriePere)) {
                            echo "<span>></span><a href='./categorie.php?id=" . $categoriePere["idCategorie"] . "'>" . $categoriePere["nomCategorie"] . "</a>";
                        }
                        echo "<span>></span><a href='./categorie.php?id=" . $categorie["idCategorie"] . "'>" . $categorie["nomCategorie"] . "</a><span>></span><a href='produit.php?id=" . $produit["refProduit"] . "'>" . $produit["nomProduit"] . "</a>
                    </div>";
                    /* A RETIRER QUAND LA TABLE ASSOPRODUITCATEG SERA REMPLIE */

                    echo "<div class='produit'>
                        <div class='images'>";
                            foreach ($images as $image) {
                                echo "<img src='" . $image["imageProduit"] . "' alt='" . $produit["nomProduit"] . "'>";
                            }
                        echo "</div>
                        <div class='details'>";
                            if (isset($moyenne)) {
                                for ($i = 0; $i < $moyenne; $i++) {
                                    echo "<i class='fas fa-star color'></i>";
                                }
                                for ($i = 0; $i < 5 - $moyenne; $i++) {
                                    echo "<i class='fas fa-star'></i>";
                                }
                            }
                            echo "<h2>" . $produit["nomProduit"] . "</h2>
                            <div class='categories'>";
                                foreach ($categories as $cat) {
                                    echo "<span>";

                                        $sql = "SELECT * FROM Categorie WHERE idCategorie = :cat";
                                        $req = $conn -> prepare($sql);
                                        $req -> execute(["cat" => $cat["idCategorie"]]);
                                        $categorie = $req -> fetch();

                                        if (isset($categorie["idCategoriePere"])) {
                                            $sql = "SELECT * FROM Categorie WHERE idCategorie = :cat";
                                            $req = $conn -> prepare($sql);
                                            $req -> execute(["cat" => $categorie["idCategoriePere"]]);
                                            $categoriePere = $req -> fetch();
                                            echo "<a href='./categorie.php?id=" . $categoriePere["idCategorie"] . "'>" . $categoriePere["nomCategorie"] . "</a> > ";
                                        }

                                        echo "<a href='./categorie.php?id=" . $categorie["idCategorie"] . "'>" . $categorie["nomCategorie"] . "</a>
                                    </span>";
                                }
                                echo "</div>
                            <p>" . $produit["descProduit"] . "</p>
                            <table>
                                <tr class='head'>
                                    <td>Taille</td>
                                    <td>Couleur</td>
                                </tr>
                                <tr>
                                    <td>" . $produit["tailleProduit"] . "</td>
                                    <td>" . $produit["couleurProduit"] . "</td>
                                </tr>
                            </table>
                            <span class='prix'>" . number_format($produit["prixProduit"], 2, ",", " ") . " €</span>
                            <form action='panier.php' method='POST'>
                                <input type='hidden' name='id' value='" . $produit["refProduit"] . "'>
                                <input type='hidden' name='amount' value='1'>";
                                if ($produit["qteProduit"] != 0) {
                                    echo "<button type='submit' name='commander'>Ajouter au panier (" . $produit["qteProduit"] . " en stock)</button>";
                                } else {
                                    echo "<button type='submit' name='commander' disabled>Rupture de stock</button>";
                                }
                            echo "</form>
                        </div>
                    </div>
                    
                    <div class='avis'>";
                    if (count($avis) == 0) {
                            echo "<h2>Avis</h2>
                            <p>Aucun avis pour ce produit.</p>";
                        } else {
                            foreach ($avis as $avi) {
                                $sql = "SELECT nomClient, prenomClient FROM Client WHERE idClient = :id";
                                $req = $conn -> prepare($sql);
                                $req -> execute(["id" => $avi["idClient"]]);
                                $client = $req -> fetch();

                                if (isset($avi["idAvisPere"])) {
                                    $sql = "SELECT commentaire FROM Client WHERE idAvis = :id";
                                    $req = $conn -> prepare($sql);
                                    $req -> execute(["id" => $avi["idAvisPere"]]);
                                    $reponse = $req -> fetch()["commentaire"];
                                }

                                echo "<h2>Avis (" . count($avis) . ")</h2>
                                <div class='avi'>
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
                                            <h3>" . $client["prenomClient"] . " " . $client["nomClient"] .  "</h3>
                                        </div>
                                        <p>" . $avi["commentaire"] . "</p>";
                                        if (isset($reponse)) {
                                            echo "<h4>Disguise'Hub</h4>
                                            <p>" . $reponse . "</p>";
                                        }
                                    echo "</div>";
                                    if (isset($avi["imageAvis"])) {
                                        echo "<img src='" . $avi["imageAvis"] . "' alt='Photo de l'avis " . $avi["idAvis"] . "'>";
                                    }
                                echo "</div>";
                            }
                        }
                    echo "</div>";
                }
            }
        ?>

    </div>

    <?php include("include/footer.php"); ?>

</body>

</html>