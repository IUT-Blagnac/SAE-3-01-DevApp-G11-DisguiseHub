<?php
include("../include/connect.inc.php");

if (isset($_GET['RefProduit'])) {
    $refProduit = $_GET['RefProduit'];

    // Affichage de la confirmation en JavaScript
    echo '<script language="JavaScript" type="text/javascript">';
    echo 'var userConfirmation = confirm("Êtes-vous sûr de vouloir supprimer ce produit ?");';
    echo 'if (userConfirmation) {';
    echo '  var deleteUrl = "delete_produit.php?RefProduit=' . $refProduit . '";'; // URL pour effectuer la suppression côté serveur
    echo '  window.location.replace(deleteUrl);'; // Redirection vers la suppression côté serveur
    echo '} else {';
    echo '  alert("Suppression annulée");'; // Alerte de suppression annulée
    echo '  var productUrl = "produit.php?RefProduit=' . $refProduit . '";';
    echo '  window.location.replace(productUrl);'; // Redirection vers la page du produit en cas d'annulation
    echo '}';
    echo '</script>';
} else {
    // Si le paramètre RefProduit n'est pas présent
    echo '<script language="JavaScript" type="text/javascript">';
    echo 'alert("Suppression non effectuée");';
    echo 'window.location.replace("produit.php?RefProduit=' . $refProduit . '");';
    echo '</script>';
    exit();
}
?>
