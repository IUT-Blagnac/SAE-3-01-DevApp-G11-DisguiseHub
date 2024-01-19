

<?php
require_once("../include/connect.inc.php");


if (isset($_GET['id'])) {
    $idProduit = $_GET['id'];

   
    $query = $conn->prepare("SELECT * FROM Produit WHERE refProduit = :idProduit");
    $query->execute(['idProduit' => $idProduit]);
    
    if ($query->rowCount() > 0) {
       
        $produitData = $query->fetch(PDO::FETCH_ASSOC);

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["Valider"])) {
       
            $nomProduit = filter_var($_POST["nomProduit"]);
            $descProduit = filter_var($_POST["descProduit"]);
            $prixProduit = filter_var($_POST["prixProduit"]);
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

    <h1>Modification du Produit n° <?php echo htmlspecialchars($produitData['refProduit']); ?></h1>

    <form method="post" enctype="multipart/form-data">

        
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



