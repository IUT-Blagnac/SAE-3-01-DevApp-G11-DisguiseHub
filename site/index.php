<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Disguise'Hub</title>
    <link rel="apple-touch-icon" sizes="180x180" href="/~saephp11/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/~saephp11/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/~saephp11/img/favicon/favicon-16x16.png">
    <meta name="theme-color" content="#DE6E22">
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="./css/general.css">
    <link rel="stylesheet" type="text/css" href="./css/index.css">
    <script type="text/javascript" src="./include/fontawesome.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<body>
    <?php include("./include/header.php"); ?>


    <div class="home-page">
        <h1>Bienvenue sur Disguise'Hub</h1>
        <br><br><br>
        <p>Découvrez nos catégories :</p>
        <br><br><br>
        <div class="categories">
            <?php
            $statement = "SELECT * FROM Categorie WHERE idCategoriePere IS NULL";
            require_once("./include/connect.inc.php");

            $req = $conn->prepare($statement);
            $req->execute();

            while ($cat = $req->fetch()) {
                echo "<div class='category-container'>
                        <a href='recherche.php?cat=" . $cat["idCategorie"] . "'>
                            <img class='category-image' src='./img/" . $cat["nomCategorie"] . ".jpg' alt='Image " . $cat["nomCategorie"] . "' />
                            <p class='category-name'>" . strtoupper($cat["nomCategorie"]) . "</p>
                        </a>
                       
                      </div>";
            }

            $req->closeCursor();
            ?>
        </div>

        <div class="product-manager">
            <h2>Catalogue de produits</h2>
            <div class="products">
                <?php
                $productStatement = "SELECT * FROM Produit";
                $productReq = $conn->prepare($productStatement);
                $productReq->execute();


                while ($product = $productReq->fetch()) {

                    $sql = "SELECT * FROM Image WHERE refProduit = :produit";
                    $req = $conn->prepare($sql);
                    $req->execute(["produit" => $product["refProduit"]]);
                    $image = $req->fetch()["imageProduit"];

                    echo "<a href='produit.php?id=" . $product["refProduit"] . "' class='product-link'>
                            <div class='product-container'>
                            <img class='product-image' src='" . $image . "' alt='Image " . $product["nomProduit"] . "' />
                                <p class='product-name'>" . $product["nomProduit"] . "</p>
                                <p class='product-description'>" . $product["descProduit"] . "</p>
                                <p class='product-price'>" . $product["prixProduit"] . " €</p>
                            </div>
                          </a>";
                }

                $productReq->closeCursor();
                ?>
            </div>
        </div>
    </div>
    <br>
    <?php include("./include/footer.php"); ?>
</body>

</html>