<html>

<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="../css/general.css">
    <link rel="stylesheet" href="../css/admin/modifierproduit.css"> 
    <script type="text/javascript" src="./include/fontawesome.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Produit - Disguise'Hub</title>
</head>

<body>
    <?php include("../include/header.php"); ?>

    <form method="post" enctype="multipart/form-data">
        <?php
        $refProduit = isset($_POST['refProduit']) ? $_POST['refProduit'] : '';
        ?>
        <input type="hidden" name="refProduit" value="<?php echo htmlspecialchars($produitData['refProduit']); ?>">
        
        <center>
            <table border="3">
                <tbody>
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
                        <td>Quantité en stock :</td>
                        <td><input type="number" name="qteProduit" value="<?php echo htmlspecialchars($produitData['qteProduit']); ?>"></td>
                    </tr>
                </tbody>
            </table>
        </center>
        <br>
        <center>
            <input type="submit" name="Valider" value="Valider">
        </center>
    </form>

    <?php include("../include/footer.php"); ?>
</body>

</html>
