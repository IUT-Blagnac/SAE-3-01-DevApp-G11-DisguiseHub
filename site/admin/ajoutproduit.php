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

            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["Valider"])) {
                // Récupérer les valeurs du formulaire
                $nomProduit = $_POST["nomProduit"];
                $descProduit = $_POST["descProduit"];
                $prixProduit = $_POST["prixProduit"];
            
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
                        // Vérifier si un fichier a été téléchargé
                        if (isset($_FILES['ficImg']) && $_FILES['ficImg']['error'] == 0) {
                            // Vérifier le type de fichier (JPEG) et la taille (<= 100 Ko)
                            $allowedTypes = ['image/jpeg'];
                            $maxFileSize = 100 * 1024; // 100 Ko
            
                            if (in_array($_FILES['ficImg']['type'], $allowedTypes) && $_FILES['ficImg']['size'] <= $maxFileSize) {
                                // Insérer les données dans la table Produit
                                $req = $conn->prepare("
                                    INSERT INTO Produit (nomProduit, descProduit, prixProduit)
                                    VALUES (:nomProduit, :descProduit, :prixProduit)
                                ");
            
                                // Charger l'image dans le dossier du serveur
                                $imageFileName = 'img/' . $nomProduit . ".jpg";
                                move_uploaded_file($_FILES['ficImg']['tmp_name'], $imageFileName);
            
                                $req->execute([
                                    'nomProduit' => $nomProduit,
                                    'descProduit' => $descProduit,
                                    'prixProduit' => $prixProduit
                                ]);
            
                                echo '<script language="JavaScript" type="text/javascript">
                                    alert("Ajout effectué !");
                                    // Rediriger vers la page de consultation des produits
                                    window.location.replace("consulterproduit.php");
                                    </script>';
                            } else {
                                echo '<script language="JavaScript" type="text/javascript">
                                    alert("Erreur : Veuillez télécharger une image JPEG de taille maximale 100 Ko.");
                                    </script>';
                            }
                        } else {
                            echo '<script language="JavaScript" type="text/javascript">
                                alert("Erreur : Veuillez sélectionner une image.");
                                </script>';
                        }
                    }
                } else {
                    echo '<script language="JavaScript" type="text/javascript">
                        alert("Erreur : Veuillez remplir le nom du produit et la description.");
                        </script>';
                }
            }
            ?>

            <form method="post" enctype="multipart/form-data">
                <!-- Your form fields go here, similar to the existing form -->
                <!-- For example: -->
                <label>Nom du Produit:</label>
                <input type="text" name="nomProduit" required>

                <label>Description:</label>
                <textarea name="descProduit" rows="4" required></textarea>

                <label>Prix:</label>
                <input type="text" name="prixProduit" required>

                <!-- Add other fields as needed -->

                <label>Image du Produit:</label>
                <input type="file" name="ficImg" required>

                <input type="submit" name="Valider" value="Ajouter Produit">
            </form>
        </div>

    </div>

    <?php include("../include/footer.php"); ?>

</body>

</html>
