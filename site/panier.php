<html>

<head>
    <title>Panier - Disguise'Hub</title>
    <link rel="apple-touch-icon" sizes="180x180" href="/~saephp11/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/~saephp11/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/~saephp11/img/favicon/favicon-16x16.png">
    <meta name="theme-color" content="#DE6E22">
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="./css/general.css">
    <link rel="stylesheet" type="text/css" href="./css/panier.css">
    <script type="text/javascript" src="./include/fontawesome.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

    <?php session_start(); ?>

    <?php include("./include/header.php"); ?>

    <?php
        $cartedit = false;

        // Vérifiez si le formulaire est soumis
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            
            $cart = [];
            if (isset($_COOKIE["cart"])) {
                $cart = json_decode($_COOKIE["cart"], true);
            }

            echo "<script>console.log(" . json_encode($_POST) . ")</script>";
            if (isset($_POST["creercommande"])) {
                if (!isset($_SESSION["connexion"])) {
                    echo "<script>alert('Vous devez être connecté pour commander.')</script>";
                    header("Location: compte");
                    exit();
                }
                if (empty($cart)) {
                    echo "<script>alert('Votre panier est vide.')</script>";
                    header("Location: panier.php");
                    exit();
                }
                if (empty($_POST["adresse"]) || empty($_POST["ville"]) || empty($_POST["postal"]) || empty($_POST["pays"])) {
                    echo "<script>alert('Veuillez remplir tous les champs.')</script>";
                    header("Location: panier.php");
                    exit();
                }
                foreach ($cart as $id => $amount) {

                    $sql = "SELECT * FROM Produit WHERE refProduit = :ref";
                    $req = $conn -> prepare($sql);
                    $req -> execute(["ref" => htmlspecialchars($id)]);
                    $product = $req -> fetch();

                    $sql = "";

                    if ($product["qteProduit"] < $amount) {
                        echo "<script>alert('Le produit \"" . $product["nomProduit"] . "\" est en rupture de stock.')</script>";
                        header("Location: panier.php");
                        exit();
                    }

                }

                $sql = "SELECT * FROM Client WHERE idClient = :id";

                $sql = "INSERT INTO Commande (idClient, dateCommande, fraisLivraison, adrLivraison, villeLivraison, codePostalLivraison, paysCommande) VALUES (:idClient, :dateCommande, 4.99, :adrLivraison, :villeLivraison, :codePostalLivraison, :paysCommande)";
                $req = $conn -> prepare($sql);
                $req -> execute([
                    "idClient" => htmlspecialchars($_SESSION["connexion"]),
                    "dateCommande" => htmlspecialchars(date("Y-m-d")),
                    "adrLivraison" => htmlspecialchars($_POST["adresse"]),
                    "villeLivraison" => htmlspecialchars($_POST["ville"]),
                    "codePostalLivraison" => htmlspecialchars($_POST["postal"]),
                    "paysCommande" => htmlspecialchars($_POST["pays"])
                ]);
                $idCommande = $conn -> lastInsertId();

                foreach ($cart as $id => $amount) {
                    $sql = "INSERT INTO Commander (refProduit, idCommande, qteCommandee) VALUES (:refProduit, :idCommande, :qteCommandee)";
                    $req = $conn -> prepare($sql);
                    $req -> execute([
                        "refProduit" => htmlspecialchars($id),
                        "idCommande" => htmlspecialchars($idCommande),
                        "qteCommandee" => htmlspecialchars($amount)
                    ]);
                }

                setcookie('cart', '', time() - 3600, '/');
                header("Location: compte/commandes/detail.php?id=" . $idCommande . "&commande");
                exit();
            }

            $id = $_POST["id"];
            $amount = $_POST["amount"];

            $sql = "SELECT * FROM Produit WHERE refProduit = :ref";
            $req = $conn -> prepare($sql);
            $req -> execute(["ref" => htmlspecialchars($id)]);
            $nbresult = $req -> rowCount();

            function ajout() {
                global $cart, $id, $req, $nbresult;
                if ($nbresult == 0) {
                    echo "<script>alert('Le produit \"" . $id . "\" est introuvable.')</script>";
                    unset($cart[$id]);
                } else if ($nbresult > 1) {
                    echo "<script>alert('Une erreur est survenue avec le produit \"" . $id . "\".')</script>";
                    unset($cart[$id]);
                } else {
                    $product = $req -> fetch();
                    if (!isset($cart[$id])) {
                        $futurquantite = 1;
                    } else {
                        $futurquantite = $cart[$id] + 1;
                    }
                    if ($product["qteProduit"] >= $futurquantite) {
                        if (!isset($cart[$id])) {
                            $cart[$id] = 1;
                        } else {
                            $cart[$id]++;
                        }
                    } else {
                        if (isset($_POST["commander"])) {
                            header("Location: produit.php?id=" . $id . "&erreur=Produit+en+rupture+de+stock");
                            exit();
                        } else {
                            echo "<script>alert('Ajout impossible, le produit \"" . $product["nomProduit"] . "\" est en rupture de stock.')</script>";
                        }
                    }
                }
            }
            
            switch (true) {
                case isset($_POST["moins"]):
                    if (isset($cart[$id])) {
                        $cart[$id]--;
                        if ($cart[$id] <= 0) {
                            unset($cart[$id]);
                        }
                    }
                    break;
                case isset($_POST["plus"]):
                    ajout();
                    break;
                case isset($_POST["supprime"]):
                    unset($cart[$id]);
                    break;
                case isset($_POST["ajuste"]):
                    if ($nbresult == 1) {
                        $product = $req -> fetch();
                        if ($product["qteProduit"] == 0) {
                            unset($cart[$id]);
                        } else {
                            $cart[$id] = $product["qteProduit"];
                        }
                    } else {
                        unset($cart[$id]);
                    }
                    break;
                case isset($_POST["commander"]):
                    ajout();
            }
            
            if (count($cart) == 0) {
                setcookie('cart', '', time() - 3600, '/');
            } else {
                setcookie('cart', json_encode($cart), time() + (86400 * 30), '/');
            }

            if (isset($_POST["commander"])) {
                header("Location: produit.php?id=$id");
                exit();
            }

            $cartedit = true;
        }
        
    ?>

    <div class="content">

        <div class="panier">

            <h1>Panier</h1>

            <?php
                
                // Récupération du panier dans le cookie (si non modifié au-dessus)
                if (!$cartedit && isset($_COOKIE["cart"]) && !empty(json_decode($_COOKIE["cart"], true))) {
                    $cart = json_decode($_COOKIE["cart"], true);
                }

                // Démarrage session
                
                // Panier trouvé et non vide
                if (isset($cart) && !empty($cart)) {

                    $valide = true;

                    echo "<table>
                        <tr class='head'>
                                <td class='nom'>Nom</td>
                            <td class='couleur'>Couleur</td>
                            <td class='taille'>Taille</td>
                            <td class='prix'>Prix</td>
                            <td class='quantite'>Quantité</td>
                        </tr>";

                        $total = 0;

                        foreach ($cart as $id => $amount) {
                            
                            echo "<tr>
                                <form action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='POST'>";

                            $sql = "SELECT * FROM Produit WHERE refProduit = :ref";
                            $req = $conn -> prepare($sql);
                            $req -> execute(["ref" => htmlspecialchars($id)]);
                            
                            // Cas d'erreurs
                            if ($req && $req->rowCount() != 1) {

                                $valide = false;

                                echo "<td class='erreur' colspan='5'>
                                    <div>
                                        <input type='hidden' name='id' value='" . $id . "'>
                                        <input type='hidden' name='amount' value='" . $amount . "'>";
                                        if ($req->rowCount() > 1) {
                                            echo "<a>Une erreur est survenue avec le produit \"" . $id . "\"</a>";
                                        } else if ($req->rowCount() == 0) {
                                            echo "<a>Produit \"" . $id . "\" introuvable</a>";
                                        }
                                        echo "<button type='submit' name='ajuste' class='ignore'>
                                            <i class='fa-regular fa-xmark' style='color: #FFFFFF;'></i>
                                        </button>
                                    </div>
                                </td>";

                            // Produit trouvé
                            } else {
                                $product = $req -> fetch();

                                // Rupture de stock
                                if ($product["qteProduit"] < $amount) {

                                    $valide = false;
                                    
                                    echo "<td class='erreur' colspan='5'>
                                        <div>
                                            <input type='hidden' name='id' value='" . $id . "'>
                                            <input type='hidden' name='amount' value='" . $amount . "'>";
                                            if ($product["qteProduit"] == 0) {
                                                echo "<a>Produit \"" . $product["nomProduit"] . "\" en rupture de stock</a>
                                                <button type='submit' name='ajuste' class='ignore'>
                                                    <i class='fa-regular fa-xmark' style='color: #FFFFFF;'></i>
                                                </button>";
                                            } else {
                                                echo "<a>Il ne reste que " . $product["qteProduit"] . " exemplaires du produit \"" . $product["nomProduit"] . "\"</a>
                                                <button type='submit' name='ajuste' class='ignore'>
                                                    <i class='fa-regular fa-circle-minus' style='color: #FFFFFF;'></i>
                                                </button>";
                                            }
                                        echo "</div>
                                    </td>";

                                // Affichage normal
                                } else {
                                    $total += $product["prixProduit"] * $amount;
                                    echo "<td class='nom'>
                                        <input type='hidden' name='id' value='" . $id . "'>
                                        <a>" . $product["nomProduit"] . "</a>
                                    </td>
                                    <td class='couleur'>" . $product["couleurProduit"] . "</td>
                                    <td class='taille'>" . $product["tailleProduit"] . "</td>
                                    <td class='prix'>" . number_format($product["prixProduit"], 2, ",", " ") . " €</td>
                                    <td class='quantite'>
                                        <input type='hidden' name='amount' value='" . $amount . "'>
                                        <button type='submit' name='moins' class='ignore'>
                                            <i class='fa-regular fa-circle-minus'></i>
                                        </button>" . $amount . "";
                                        if ($product["qteProduit"] >= $amount + 1) {
                                            echo "<button type='submit' name='plus' class='ignore'>
                                                <i class='fa-regular fa-circle-plus'></i>
                                            </button>";
                                        } else {
                                            echo "<button type='submit' name='plus' class='ignore' style='cursor: not-allowed;' disabled>
                                                <i class='fa-regular fa-circle-plus'></i>
                                            </button>";
                                        }
                                    echo "</td>";
                                }
                            }
                                echo "</form>
                            </tr>";
                        }

                        echo "</table>
                    </div>";

                    echo "<div class='commande'>
                        <div class='prix'>
                            <p>Total : <span>(hors frais de port)</span></p>
                            <a>" . number_format($total, 2, ",", " ") . " €</a>
                        </div>";

                    // Utilisateur non connecté
                    if (!isset($_SESSION["connexion"])) {
                        echo "<a class='button' href='/~saephp11/compte'>Se connecter pour commander</a>";

                    // Utilisateur connecté (formulaire de commande)
                    } else {
                        $sql = "SELECT * FROM Client WHERE idClient = :id";
                        $req = $conn -> prepare($sql);
                        $req -> execute(["id" => htmlspecialchars($_SESSION["connexion"])]);

                        if ($req->rowCount() != 1) {
                            echo "<script>alert('Une erreur est survenue.')</script>";
                            header("Location: compte");
                            exit();
                        } else {
                            $client = $req -> fetch();
                        }

                        echo "<form action='" . $_SERVER["PHP_SELF"] . "' method='POST'>
                            <label>Adresse</label>
                            <input type='text' name='adresse' autocomplete='street-address' value='" . $client["adresseClient"] . "' required>
                    
                            <label>Ville</label>
                            <input type='text' name='ville' autocomplete='address-level2' value='" . $client["villeClient"] . "' required>

                            <label>Code postal</label>
                            <input type='number' name='postal' autocomplete='postal-code' value='" . $client["codePostalClient"] . "' required>
                    
                            <label>Pays</label>
                            <input type='text' name='pays' autocomplete='country-name' required>";
                            
                            if($valide) {
                                echo "<button type='submit' name='creercommande'>Commander</button>";
                            } else {
                                echo "<button disabled>Commander</button>";
                            }
                        echo "</form>";
                    }

                } else {
                    echo "<p>Votre panier est vide.</p>";
                }
            ?>

        </div>
        
    </div>

    <?php include("./include/footer.php"); ?>

</body>

</html>