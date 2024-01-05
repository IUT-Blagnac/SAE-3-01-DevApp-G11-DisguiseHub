<html>

<head>
    <title>Disguise'Hub</title>
    <link rel="apple-touch-icon" sizes="180x180" href="/~saephp11/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/~saephp11/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/~saephp11/img/favicon/favicon-16x16.png">
    <meta name="theme-color" content="#DE6E22">
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
                while ($produit = $req->fetch()) {
                    require("./include/apercuProduit.php");
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