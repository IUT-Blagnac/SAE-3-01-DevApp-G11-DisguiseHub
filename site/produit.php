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
                                <tr class='head'>";
                                if (isset($produit["tailleProduit"])) {
                                    echo "<td>Taille</td>";
                                }
                                if (isset($produit["couleurProduit"])) {
                                    echo "<td>Couleur</td>";
                                }
                                echo "</tr>
                                <tr>";
                                    if (isset($produit["tailleProduit"])) {
                                        echo "<td>" . $produit["tailleProduit"] . "</td>";
                                    }
                                    if (isset($produit["couleurProduit"])) {
                                        echo "<td>" . $produit["couleurProduit"] . "</td>";
                                    }
                                echo "</tr>
                            </table>";
                            if ($produit["qteProduit"] != 0) {
                                if (isset($_COOKIE["cart"]) && !empty(json_decode($_COOKIE["cart"], true)) && isset((json_decode($_COOKIE["cart"], true))[$produit["refProduit"]])) {
                                    echo "<a class='button' href='panier.php'>Dans le panier</a>";
                                } else {
                                    echo "<form action='panier.php' method='POST'>
                                        <input type='hidden' name='id' value='" . $produit["refProduit"] . "'>
                                        <input type='hidden' name='amount' value='1'>
                                        <button type='submit' name='commander'>Ajouter au panier (" . $produit["qteProduit"] . " en stock)</button>
    
                                    </form>";
                                }
                            } else {
                                echo "<button type='submit' name='commander' disabled>Rupture de stock</button>";
                            }
                            echo "<span class='prix'>" . number_format($produit["prixProduit"], 2, ",", " ") . " €</span>
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
                    echo "<div class=\"boutons-actions\">
                    <a href='./admin/ajoutproduit.php' class='button'>Ajouter produit</a>
                    <a href='./admin/modifierproduit.php?id=" . $produit["refProduit"] . "' class='button'>Modifier produit</a>
                    <a href='./admin/supprimerproduit.php?id=" . $produit["refProduit"] . "' class='button'>Supprimer produit</a>

                </div>";
                
                }
            }
        ?>

    </div>

    <?php include("include/footer.php"); ?>

</body>

</html>