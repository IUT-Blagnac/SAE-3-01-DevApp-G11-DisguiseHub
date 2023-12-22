<html>

<head>
    <title>Catégorie - Disguise'Hub</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="./css/general.css">
    <link rel="stylesheet" type="text/css" href="./css/categorie.css">
    <script type="text/javascript" src="./include/fontawesome.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

    <?php include("include/header.php"); ?>

    <div class="content">

        <?php
            // Si aucune catégorie n'est spécifiée
            if (empty($_GET["id"])) {
                header("Location: ./");
            } else {
                $sql = "SELECT * FROM Categorie WHERE idCategorie = :id";
                $req = $conn -> prepare($sql);
                $req -> execute(["id" => $_GET["id"]]);

                // Cas d'erreurs
                if ($req && $req->rowCount() > 1) {
                    echo "<h1>Erreur</h1>
                    <p>Plusieurs correspondaces ont été trouvées pour la catégorie \"" . $_GET["id"] . "\".</p>
                    <a href='./' class='button'>Retour à l'accueil</a>";
                } else if ($req && $req->rowCount() == 0) {
                    echo "<h1>Catégorie introuvable</h1>
                    <p>La catégorie \"" . $_GET["id"] . "\" n'existe pas.</p>
                    <a href='./' class='button'>Retour à l'accueil</a>";
                } else {
                    $categorie = $req -> fetch();

                    echo "<script type='text/javascript'>
                        document.title = '" . $categorie["nomCategorie"] . " - Disguise\'Hub'
                    </script>
                    
                    <h1>" . $categorie["nomCategorie"] . "</h1>";

                    if (isset($categorie["idCategoriePere"])) {
                        $sql = "SELECT * FROM Categorie WHERE idCategorie = :id";
                        $req = $conn -> prepare($sql);
                        $req -> execute(["id" => $categorie["idCategoriePere"]]);
                        $categoriePere = $req -> fetch();

                        echo "<a class='categoriepere' href='/~saephp11/categorie.php?id=" . $categoriePere["idCategorie"] . "'>" . $categoriePere["nomCategorie"] . "</a>";
                    }

                    echo "<div class='articles'>";
                    
                        $sql = "SELECT * FROM AssoProduitCateg WHERE idCategorie = :id";
                        $req = $conn -> prepare($sql);
                        $req -> execute(["id" => $_GET["id"]]);
                        $articles = $req -> fetchAll();

                        foreach ($articles as $article) {
                            $sql = "SELECT * FROM Produit WHERE refProduit = :id";
                            $req = $conn -> prepare($sql);
                            $req -> execute(["id" => $article["refProduit"]]);
                            $produit = $req -> fetch();

                            $sql = "SELECT * FROM Image WHERE refProduit = :id";
                            $req = $conn -> prepare($sql);
                            $req -> execute(["id" => $article["refProduit"]]);
                            
                            echo "<a class='article' href='/~saephp11/produit.php?id=" . $produit["refProduit"] . "'>";
                            
                            if ($req && $req->rowCount() > 0) {
                                $image = $req -> fetch();
                                echo "<img src='" . $image["imageProduit"] . "' alt='" . $produit["nomProduit"] . "'>";
                            }

                                echo "<h2>" . $produit["nomProduit"] . "</h2>
                                <p>" . $produit["tailleProduit"] . " - " . $produit["couleurProduit"] . "</p>
                                <span>" . $produit["prixProduit"] . "€</span>
                            </a>";
                        }
                    echo "</div>";
                }
            }
        ?>

    </div>

    <?php include("include/footer.php"); ?>

</body>

</html>