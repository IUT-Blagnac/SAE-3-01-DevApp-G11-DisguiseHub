<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Disguise'Hub - Détail du Produit</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="./css/general.css">
    <link rel="stylesheet" type="text/css" href="./css/detail_produit.css">
    <script type="text/javascript" src="./include/fontawesome.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <?php include("./include/header.php"); ?>

    <div class="product-details-container">
        <?php
        if (isset($_GET['id'])) {
            $refProduit = $_GET['id'];
            require_once("../include/connect.inc.php");

            // Remplacez cette section par votre propre code de requête SQL pour récupérer les détails du produit
            $productStatement = "SELECT * FROM Produit WHERE refProduit = :refProduit";
            $productReq = $conn->prepare($productStatement);
            $productReq->bindParam(':refProduit', $refProduit);
            $productReq->execute();
            $product = $productReq->fetch();

            if ($product) {
                echo "<h1>" . $product["nomProduit"] . "</h1>";
                echo "<img class='product-image' src='./img/produits/" . $product["imageProduit"] . "' alt='Image " . $product["nomProduit"] . "' />";
                echo "<p>" . $product["descProduit"] . "</p>";
                echo "<p>Prix: " . $product["prixProduit"] . " €</p>";
                // Ajoutez plus de détails du produit si nécessaire
            } else {
                echo "<p>Produit non trouvé.</p>";
            }

            $productReq->closeCursor();
        } else {
            echo "<p>Identifiant du produit non spécifié.</p>";
        }
        ?>
    </div>

    <?php include("./include/footer.php"); ?>
</body>
</html>
