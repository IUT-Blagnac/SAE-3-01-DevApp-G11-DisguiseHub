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
        <div>
            <div>";
                if (isset($produit["tailleProduit"])) {
                    echo "<span>" . $produit["tailleProduit"] . "</span>";
                }
                if (isset($produit["couleurProduit"])) {
                    echo "<span>" . $produit["couleurProduit"] . "</span>";
                }
            echo "</div>";
            if (isset($produit["prixSolde"])) {
                echo "<span class='prix'>
                    <span class='solde'>" . number_format($produit["prixProduit"], 2, ",", " ") . " €</span>
                    " . number_format($produit["prixSolde"], 2, ",", " ") . " €
                </span>";
            } else {
                echo "<span class='prix'>" . number_format($produit["prixProduit"], 2, ",", " ") . " €</span>";
            }
        echo "</div>
    </a>";
?>