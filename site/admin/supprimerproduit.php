<?php
include("../include/connect.inc.php");

if (isset($_GET['id'])) {
    $refProduit = $_GET['id'];

    $deleteQuery = $conn->prepare("DELETE FROM Produit WHERE refProduit = :refProduit");
    $deleteQuery->execute(['refProduit' => $refProduit]);

    if ($deleteQuery->rowCount() > 0) {
        echo '<script language="JavaScript" type="text/javascript">';
        echo 'alert("Produit supprimé avec succès");';
        echo 'window.location.replace("gestionnaireproduit.php");';
        echo '</script>';
        exit();
    } else {
        echo '<script language="JavaScript" type="text/javascript">';
        echo 'alert("Erreur lors de la suppression du produit");';
        echo 'window.location.replace("gestionnaireproduit.php");';
        echo '</script>';
        exit();
    }
} else {
    echo '<script language="JavaScript" type="text/javascript">';
    echo 'alert("Paramètre manquant pour la suppression du produit");';
    echo 'window.location.replace("gestionnaireproduit.php");';
    echo '</script>';
    exit();
}
?>
