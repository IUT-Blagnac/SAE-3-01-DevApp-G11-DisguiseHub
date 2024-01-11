<?php
include("connect.inc.php");

if (isset($_GET['pIdProduit'])) {
    $idProduit = $_GET['pIdProduit'];

    // Suppression de l'enregistrement dans la base de données
    $req = $conn->prepare("DELETE FROM Produit WHERE refProduit = ?");
    $req->execute([$idProduit]);

    // Redirection vers la page de consultation après la suppression
    header("Location: index.php");
    exit();
} else {
    // Si l'ID du produit n'est pas défini, redirigez vers la page d'accueil
    header("Location: index.php");
    exit();
}
?>
