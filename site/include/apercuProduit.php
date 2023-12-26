<?php
    $sql = "SELECT * FROM Image WHERE refProduit = :produit";
    $req = $conn->prepare($sql);
    $req->execute(["produit" => $produit["refProduit"]]);
    $image = $req->fetch();

    echo "<a href='/~saephp11/produit.php?id=" . $produit["refProduit"] . "' class='produit'>";
        if (isset($image["imageProduit"])) {
            echo "<img src='" . $image["imageProduit"] . "' alt='" . $produit["nomProduit"] . "' />";
        }
        echo "<h3>" . $produit["nomProduit"] . "</h3>
        <p>";
        if (isset($produit["tailleProduit"])) {
            echo $produit["tailleProduit"];
        }
        if (isset($produit["tailleProduit"]) && isset($produit["couleurProduit"])) {
            echo " - ";
        }
        if (isset($produit["couleurProduit"])) {
            echo $produit["couleurProduit"];
        }
        echo "</p>
        <span class='prix'>" . number_format($produit["prixProduit"], 2, ",", " ") . " €</span>
    </a>";
?>