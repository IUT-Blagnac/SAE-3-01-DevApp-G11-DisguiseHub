<html>

<head>
    <title>Disguise'Hub</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="./css/general.css">
    <link rel="stylesheet" type="text/css" href="./css/recherche.css">
    <script type="text/javascript" src="./include/fontawesome.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<body>

    <?php include("./include/header.php"); ?>

    <div class="content">
        <h1>Recherche</h1>
        <form id="searchForm" method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="text" name="recherche" required value="<?php echo isset($_GET['recherche']) ? htmlspecialchars($_GET['recherche'], ENT_QUOTES, 'UTF-8') : ''; ?>">
            <select name="tri" id="optPrix" class="slct" onchange="updateUrl()">
                <option value="PERT" <?php if (!isset($_GET['tri']) || ($_GET['tri'] == 'PERT')) {
                                            echo 'selected';
                                        } ?>>Pertinence</option>
                <option value="ASC" <?php if (isset($_GET['tri']) && $_GET['tri'] == 'ASC') {
                                        echo 'selected';
                                    } ?>>Prix croissant</option>
                <option value="DESC" <?php if (isset($_GET['tri']) && $_GET['tri'] == 'DESC') {
                                            echo 'selected';
                                        } ?>>Prix décroissant</option>
            </select>
            <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
        </form>
    </div>

    <?php
    if (isset($_GET["recherche"])) {
        $recherche = $_GET["recherche"];
        $categorie = $_GET["tri"]; // ASC, DESC, PERT
        if ($categorie === "PERT") {
            $statement = "SELECT * FROM Produit WHERE nomProduit LIKE :recherche;";
        } else {
            $statement = "SELECT * FROM Produit WHERE nomProduit LIKE :recherche ORDER BY prixProduit " . $categorie . ";";
        }
        $req = $conn->prepare($statement);
        $req->bindValue(':recherche', '%' . $recherche . '%', PDO::PARAM_STR);
        $req->execute();


        if ($req->rowCount() > 0) {
            echo "<div class='products'>";
            while ($product = $req->fetch()) {
                $imageId = $product["refProduit"] - 100000;
                echo "<a href='produit.php?id=" . $product["refProduit"] . "' class='product-link'>
                            <div class='product-container'>
                             <img class='product-image' src='https://picsum.photos/360/360?image=" . $imageId . "' alt='Image " . $product["nomProduit"] . "' />
                             <p class='product-name'>" . $product["nomProduit"] . "</p>
                             <p class='product-description'>" . $product["descProduit"] . "</p>
                             <p class='product-price'>" . $product["prixProduit"] . " €</p>
                             <p class='product-size'>" . $product["tailleProduit"] . " </p>
                            </div>
                      </a>";
            }
            echo "</div>";
        } else {
            echo "<div class='no-results'>
                      <p>Aucun résultat pour votre recherche.</p>
                 </div>";
        }
    }
    ?>
    <?php include("./include/footer.php"); ?>

</body>

</html>