<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Disguise'Hub</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../css/general.css">
    <link rel="stylesheet" type="text/css" href="../css/compte/menuCompte.css">
    <script type="text/javascript" src="../include/fontawesome.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="apple-touch-icon" sizes="180x180" href="/~saephp11/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/~saephp11/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/~saephp11/img/favicon/favicon-16x16.png">
    <meta name="theme-color" content="#DE6E22">
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
        <?php include("../include/menuCompte.php"); ?>
        
        <div class="product-manager">
            <h2>Catalogue de produits</h2>

            <div class="boutons-actions">
                    <a href='/~saephp11/admin/ajoutproduit.php' class='button'>Ajouter produit</a>
            </div>
            <table class="product-table">
                <thead>
                    <tr class="head">
                        <td>Nom</td>
                        <td>Description</td>
                        <td>Prix</td>
                        <td>Prix soldé</td>
                        <td>Stock</td>
                     <!--   <th>Rajouter</th>
                        <th>Enlever</th>
                               <td>
                                <a href='/~saephp11/admin/ajouterstock.php?id=" . $product["refProduit"] . "' class='action-btn'>+1</a>
                                </td>
                                <td>
                                <a href='/~saephp11/admin/retirerstock.php?id=" . $product["refProduit"] . "' class='action-btn'>-1</a>
                                </td> 
                             -->
                        <td>Modifier</td>
                        <td>Supprimer</td>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $productStatement = "SELECT * FROM Produit";
                    $productReq = $conn->prepare($productStatement);
                    $productReq->execute();

                    while ($product = $productReq->fetch()) {
                        echo "<tr>
                                <td>" . $product["nomProduit"] . "</td>
                                <td>" . $product["descProduit"] . "</td>
                                <td>" . $product["prixProduit"] . " €</td>";
                                if (isset($product["prixSolde"])) {
                                    echo "<td>" . $product["prixSolde"] . " €</td>";
                                } else {
                                    echo "<td></td>";
                                }
                                echo "<td>" . $product["qteProduit"] . "</td>
                                <td> 
                                <a href='/~saephp11/admin/modifierproduit.php?id=" . $product["refProduit"] . "' class='action-btn'>Modifier</a>  
                                </td>
                                <td>
                                <a href='/~saephp11/admin/supprimerproduit.php?id=" . $product["refProduit"] . "' class='action-btn'>Supprimer</a>
                                </td>
                              </tr>";
                    }
                    

                    
                    
                    $productReq->closeCursor();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <br>
    <?php include("../include/footer.php"); ?>
</body>

</html>
