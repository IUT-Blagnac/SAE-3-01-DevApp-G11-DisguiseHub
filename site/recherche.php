<html>

<head>
    <title>Disguise'Hub</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="/~saephp11/css/general.css">
    <link rel="stylesheet" type="text/css" href="/~saephp11/css/recherche.css">
    <script type="text/javascript" src="/~saephp11/include/fontawesome.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<body>

    <?php include("./include/header.php"); ?>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="text" name="recherche" id="recherche" required>
            <button type="submit">Search</button>
        </form>

    <?php

    // Vérifier si le formulaire de recherche a été soumis
    if ($_SERVER["PHP_SELF"] == "GET") {
        // Récupérer la valeur de la barre de recherche
        $recherche = $_POST["recherche"];

        // Échapper les caractères spéciaux pour éviter les injections SQL
        $recherche = htmlspecialchars($recherche);

        // Requête SQL pour rechercher le produit dans la base de données
        $requete = "SELECT * FROM produits WHERE nom_produit LIKE ':$recherche'";
        $resultat = $conn->query($requete);
        $resultat->execute(["recherche" => $recherche]);

        // Vérifier s'il y a des résultats
        if ($resultat->num_rows > 0) {
            // Afficher les résultats
            echo "<h2>Résultats de la recherche pour '$recherche'</h2>";

            while ($row = $resultat->fetch_assoc()) {
                echo "<p>Nom du produit : " . $row["nom_produit"] . "</p>";
                echo "<p>Description : " . $row["description"] . "</p>";
                echo "<hr>";
            }
        }
    }

    ?>
    <?php include("./include/footer.php"); ?>

</body>

</html>