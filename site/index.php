<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Disguise'Hub</title>
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
            require_once("../include/connect.inc.php");

            $req = $conn->prepare($statement);
            $req->execute();

            while ($cat = $req->fetch()) {
                echo "<div class='category-container'>
                        <a href='recherche.php?cat=" . $cat["idCategorie"] . "'>
                            <img class='category-image' src='./img/" . $cat["nomCategorie"] . ".jpg' alt='Image " . $cat["nomCategorie"] . "' />
                        </a>
                        <p>" . $cat["nomCategorie"] . "</p>
                      </div>";
            }

            $req->closeCursor();
            ?>
        </div>

        <!-- Gestionnaire de produits -->
        <div class="product-manager">
            <h2>Gestionnaire de Produits</h2>
            <div class="products">
                <?php
                $productStatement = "SELECT * FROM Produit";
                $productReq = $conn->prepare($productStatement);
                $productReq->execute();

                while ($product = $productReq->fetch()) {
                    echo "<div class='product-container'>
                            <p class='product-name'>" . $product["nomProduit"] . "</p>
                            <p class='product-description'>" . $product["descProduit"] . "</p>
                            <p class='product-price'>" . $product["prixProduit"] . " €</p>
                          </div>";
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
