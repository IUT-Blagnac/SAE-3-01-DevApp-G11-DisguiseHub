<?php

require_once("../include/connect.inc.php");

if (isset($_GET["id"])) {
    $productId = $_GET["id"];

    
    $fetchStockQuery = $conn->prepare("SELECT qteProduit FROM Produit WHERE refProduit = :productId");
    $fetchStockQuery->execute(['productId' => $productId]);
    $currentStock = $fetchStockQuery->fetchColumn();

    $newStock = max(0, $currentStock - 1);

    $updateStockQuery = $conn->prepare("UPDATE Produit SET qteProduit = :newStock WHERE refProduit = :productId");
    $updateStockQuery->execute(['newStock' => $newStock, 'productId' => $productId]);

    header("Location: index.php");
    exit();
} else {
    header("Location: index.php");
    exit();
}
?>
