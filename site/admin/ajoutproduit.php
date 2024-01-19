<html>

<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="../css/general.css">
    <link rel="stylesheet" href="../css/admin/ajoutproduit.css"> 
    <script type="text/javascript" src="../include/fontawesome.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajout Produit - Disguise'Hub</title>

    <link rel="apple-touch-icon" sizes="180x180" href="/~saephp11/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/~saephp11/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/~saephp11/img/favicon/favicon-16x16.png">
    <meta name="theme-color" content="#DE6E22">
</head>

<body>

    <?php include("../include/header.php"); ?>

    <div class="content">

        <div class="ajout-produit">
            <h1>Ajout de Produit</h1>

            <?php
            require_once("../include/connect.inc.php");

            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["Valider"])) {
                // Récupérer les valeurs du formulaire
                $nomProduit = $_POST["nomProduit"];
                $descProduit = $_POST["descProduit"];
                $prixProduit = $_POST["prixProduit"];
                $qteProduit = $_POST["qteProduit"];
                $tailleProduit = $_POST["tailleProduit"];
                $couleurProduit = $_POST["couleurProduit"];
                $idCategorie = $_POST["idCategorie"];

                // Vérifier si le nom du produit et la description ne sont pas vides
                if (!empty($nomProduit) && !empty($descProduit)) {
                    // Vérifier si le produit existe déjà
                    $checkProduitQuery = $conn->prepare("SELECT COUNT(*) FROM Produit WHERE nomProduit = :nomProduit");
                    $checkProduitQuery->execute(['nomProduit' => $nomProduit]);
                    $produitExists = $checkProduitQuery->fetchColumn();

                    if ($produitExists) {
                        echo '<script language="JavaScript" type="text/javascript">
                            alert("Erreur : Le produit existe déjà. Veuillez choisir un autre nom de produit.");
                            </script>';
                    } else {
                        // Insérer les données dans la table Produit
                        $req = $conn->prepare("
                            INSERT INTO Produit (nomProduit, descProduit, prixProduit, qteProduit, tailleProduit, couleurProduit, idCategorie)
                            VALUES (:nomProduit, :descProduit, :prixProduit, :qteProduit, :tailleProduit, :couleurProduit, :idCategorie)
                        ");

                        $req->execute([
                            'nomProduit' => $nomProduit,
                            'descProduit' => $descProduit,
                            'prixProduit' => $prixProduit,
                            'qteProduit' => $qteProduit,
                            'tailleProduit' => $tailleProduit,
                            'couleurProduit' => $couleurProduit,
                            'idCategorie' => $idCategorie
                        ]);

                        echo '<script language="JavaScript" type="text/javascript">
                            alert("Ajout effectué !");
                            window.location.replace("/~saephp11/admin/ajoutproduit.php");
                            </script>';
                    }
                } else {
                    echo '<script language="JavaScript" type="text/javascript">
                        alert("Erreur : Veuillez remplir le nom du produit et la description.");
                        </script>';
                }
            }
            ?>
            <form method="post">

                <label>Nom du Produit:</label>
                <input type="text" name="nomProduit" required>

                <label>Description:</label>
                <textarea name="descProduit" rows="4" required></textarea>

                <label>Prix:</label>
                <input type="number" name="prixProduit" required>

                <label>Sous-catégorie:</label>
                <select name="idCategorie" required>
                    <option value="" disabled selected>Choisissez une sous-catégorie</option>
                    <?php
                    $subcategoriesQuery = $conn->query("SELECT * FROM Categorie WHERE idCategoriePere IS NOT NULL");
                    while ($subcategory = $subcategoriesQuery->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='{$subcategory['idCategorie']}'>{$subcategory['nomCategorie']}</option>";
                    }
                    ?>
                </select>

                

                <label>Taille:</label>
                <select name="tailleProduit" required>
                    <option value="S">S</option>
                    <option value="M">M</option>
                    <option value="L">L</option>
                    <option value="XL">XL</option>
                    <option value="XXL">XXL</option>
                </select>

                <label>Quantité:</label>
                <input type="number" name="qteProduit" required>

                <label>Couleur:</label>
                <input type="text" name="couleurProduit" required>

                <input type="submit" name="Valider" value="Ajouter Produit">
            </form>
        </div>

    </div>

    <?php include("../include/footer.php"); ?>

</body>

</html>
