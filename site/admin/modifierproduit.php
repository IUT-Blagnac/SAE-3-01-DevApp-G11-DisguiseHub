<html>
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="../css/general.css">
    <link rel="stylesheet" href="../css/admin/modifierproduit.css"> 
    <link rel="stylesheet" type="text/css" href="../css/compte/menuCompte.css"> 
    <script type="text/javascript" src="./include/fontawesome.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Produit - Disguise'Hub</title>
</head>
<body>
    <?php
        session_start();
        if(!isset($_SESSION["connexion"])) {
            header("location: ../compte/connexion.php");
            exit;
        }
    ?>

    <?php include("../include/header.php"); ?>

    <div class="content">
    
    <?php
        if (isset($_GET['id'])) {
            $idProduit = $_GET['id'];

        
            $query = $conn->prepare("SELECT * FROM Produit WHERE refProduit = :idProduit");
            $query->execute(['idProduit' => $idProduit]);
            
            if ($query->rowCount() > 0) {
            
                $produitData = $query->fetch(PDO::FETCH_ASSOC);

                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["Valider"])) {
            
                    $nomProduit = filter_var($_POST["nomProduit"]);
                    $descProduit = filter_var($_POST["descProduit"]);
                    $prixProduit = floatval($_POST["prixProduit"]);
                    $prixSolde = floatval($_POST["prixSolde"]);
                    $prixSoldeAncien = floatval($_POST["prixSoldeAncien"]);
                    $qteProduit = filter_var($_POST["qteProduit"]);

                
                    $updateQuery = $conn->prepare("
                        UPDATE Produit 
                        SET nomProduit = :nomProduit, descProduit = :descProduit, prixProduit = :prixProduit, qteProduit = :qteProduit
                        WHERE refProduit = :idProduit
                    ");

                    $updateQuery->execute([
                        'nomProduit' => $nomProduit,
                        'descProduit' => $descProduit,
                        'prixProduit' => $prixProduit,
                        'qteProduit' => $qteProduit,
                        'idProduit' => $idProduit
                    ]);

                    if ($prixSolde != $prixSoldeAncien) {
                        $sql = "CALL AjouterProduitsSoldes(:idProduit, :prixSolde)";
                        $req = $conn->prepare($sql);
                        $req->execute([
                            'idProduit' => $idProduit,
                            'prixSolde' => $prixSolde
                        ]);
                    }


                    echo '<script language="JavaScript" type="text/javascript">
                        alert("Mise à jour effectuée !");
                        window.location.replace("index.php");
                        </script>';
                }
            } else {
            
                echo '<script language="JavaScript" type="text/javascript">
                    alert("Numéro ID non trouvé. Redirection vers la page d\'accueil.");
                    window.location.replace("index.php");
                    </script>';
            }
        } else {

            echo "Erreur : ID du produit non spécifié.";
        
        }
    ?>

    <?php include("../include/menuCompte.php"); ?>
        
        <div>
            <h1>Modification du Produit n° <?php echo htmlspecialchars($produitData['refProduit']); ?></h1>
        
            <form method="post" enctype="multipart/form-data">
                <table>
                    <tr>
                        <td>Identifiant du Produit :</td>
                        <td><?php echo htmlspecialchars($produitData['refProduit']); ?></td>
                    </tr>
                    <tr>
                        <td>Nom du Produit :</td>
                        <td><input type="text" name="nomProduit" size="35" value="<?php echo htmlspecialchars($produitData['nomProduit']); ?>"></td>
                    </tr>
                    <tr>
                        <td>Description du Produit :</td>
                        <td><textarea name="descProduit" rows="4" cols="50"><?php echo htmlspecialchars($produitData['descProduit']); ?></textarea></td>
                    </tr>
                    <tr>
                        <td>Prix du Produit :</td>
                        <td><input type="number" step="0.01" name="prixProduit" value="<?php echo htmlspecialchars($produitData['prixProduit']); ?>"></td>
                    </tr>
                    <tr>
                        <td>Prix Soldé (laisser vide si non-soldé) :</td>
                        <td><input type="number" step="0.01" name="prixSolde" value="<?php echo htmlspecialchars($produitData['prixSolde']); ?>">
                        <input type="hidden" step="0.01" name="prixSoldeAncien" value="<?php echo htmlspecialchars($produitData['prixSolde']); ?>"></td>
                    </tr>
                    <tr>
                        <td>Quantité en stock :</td>
                        <td><input type="number" name="qteProduit" value="<?php echo htmlspecialchars($produitData['qteProduit']); ?>"></td>
                    </tr>
                </table>
                <br>
                <button type="submit" name="Valider" value="Valider">Valider</button>
            </form>
        </div>
    </div>

    <?php include("../include/footer.php"); ?>
</body>
</html>



