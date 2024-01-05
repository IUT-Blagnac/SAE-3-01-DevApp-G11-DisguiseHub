<html>

<head>
    <title>Catégorie - Disguise'Hub</title>
    <link rel="apple-touch-icon" sizes="180x180" href="/~saephp11/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/~saephp11/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/~saephp11/img/favicon/favicon-16x16.png">
    <meta name="theme-color" content="#DE6E22">
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
                    <a href='/~saephp11/' class='button'>Retour à l'accueil</a>";
                } else if ($req && $req->rowCount() == 0) {
                    echo "<h1>Catégorie introuvable</h1>
                    <p>La catégorie \"" . $_GET["id"] . "\" n'existe pas.</p>
                    <a href='/~saephp11/' class='button'>Retour à l'accueil</a>";
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

                            require("./include/apercuProduit.php");
                        }
                    echo "</div>";
                }
            }
        ?>

    </div>

    <?php include("include/footer.php"); ?>

</body>

</html>