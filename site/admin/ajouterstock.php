<?php

require_once("../include/connect.inc.php");


if (isset($_GET["id"])) {
    $productId = $_GET["id"];

    $fetchStockQuery = $conn->prepare("SELECT qteProduit FROM Produit WHERE refProduit = :productId");
    $fetchStockQuery->execute(['productId' => $productId]);
    $currentStock = $fetchStockQuery->fetchColumn();

    $newStock = $currentStock + 1;

    $updateStockQuery = $conn->prepare("UPDATE Produit SET qteProduit = :newStock WHERE refProduit = :productId");
    $updateStockQuery->execute(['newStock' => $newStock, 'productId' => $productId]);

    header("Location: /~saephp11/admin/index.php");
    exit();
} else {
    header("Location: /~saephp11/admin/index.php");
    exit();
}
?>
