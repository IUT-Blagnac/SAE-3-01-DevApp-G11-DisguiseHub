<html>

<head>
    <title>Disguise'Hub</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="/~saephp11/css/general.css">
    <link rel="stylesheet" type="text/css" href="/~saephp11/css/panier.css">
    <script type="text/javascript" src="/~saephp11/include/fontawesome.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

    <?php
    // Vérifiez si le formulaire est soumis
    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $productId = $_POST['id'];
        $quantity = $_POST['amount'];

        $cart = [];
        if (isset($_COOKIE['cart'])) {
            $cart = json_decode($_COOKIE["cart"], true);
        }

        if (isset($_POST['moins'])) {
            $cart[$productId] = $quantity - 1;
        } else if (isset($_POST["plus"])) {
            $cart[$productId] = $quantity + 1;
        } else if (isset($_POST["supprime"])) {
            unset($cart[$productId]);
        } else {
            $cart[$productId] = $quantity;
        }

        if (count($cart) == 0) {
            setcookie('cart', '', time() - 3600, '/');
        } else {
            setcookie('cart', json_encode($cart), time() + (86400 * 30), '/');
        }

        if (!isset($_POST["moins"]) && !isset($_POST["plus"]) && !isset($_POST["supprime"])) {
            header("Location: /product.php?id=$productId");
        } else {
            header("Refresh: 0");
        }
    }
    ?>

    <?php
    // TEMPORAIRE : Création cookie panier factice
    // setcookie('cart', '{"696": 1, "198": 4}', time() + (86400 * 30), '/');
    ?>

    <?php include("./include/header.php"); ?>

    <div class="content">

        <h1>Panier</h1>

        <?php
        if (isset($_COOKIE["cart"]) && json_decode($_COOKIE["cart"], true) != "[]") {

            echo "<table>";
            echo "<tr class='head'>
                        <th class='id'>ID</th>
                        <th class='amount'>Quantité</th>
                        <th class='img'>Image</th>
                        <th class='suppr'>Supprimer</th>
                    </tr>";

            $cart = json_decode($_COOKIE["cart"], true);

            foreach ($cart as $id => $amount) {
                echo "<tr>
                            <form action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='POST'>
                                <td class='id'>
                                    <input type='hidden' name='id' value='" . $id . "'>
                                    " . $id . "
                                </td>
                                <td class='amount'>
                                    <input type='hidden' name='amount' value='" . $amount . "'>
                                    <button type='submit' name='moins' class='ignore'>
                                        <i class='fa-regular fa-circle-minus'></i>
                                    </button>
                                    <a>" . $amount . "</a>
                                    <button type='submit' name='plus' class='ignore'>
                                        <i class='fa-regular fa-circle-plus'></i>
                                    </button>
                                </td>
                                <td class='img'>
                                    <img src='/~saephp11/img/products/" . $id . ".png' alt=''>
                                </td>
                                <td class='suppr'>
                                    <button type='submit' name='supprime' class='ignore'>
                                        <i class='fa-regular fa-trash'></i>
                                    </button>
                                </td>
                            </form>
                        </tr>";
            }

            echo "</table>";

            if (!isset($_SESSION["connexion"])) {
                echo "<a href='/~saephp11/compte/connexion.php'>Connectez-vous pour passer commande</a>";
            } else {
                echo "<button type='submit' name='commander'>Commander</button>";
            }
        } else {
            echo "<p>Votre panier est vide.</p>";
        }
        ?>

        <!--
        <h1 class="title">Adresse de livraison</h1>

        <label class="subtitle"><b>Adresse</b></label>
        <input type="text" placeholder="Entrer l'adresse de livraison" name="adresse" required />

        <label class="subtitle"><b>Code postal</b></label>
        <input type="number" minlength="5" maxlength="5" pattern="[0-9]" title="poste" name="codePostal" placeholder="31000" required />

        <label class="subtitle"><b>Ville</b></label>
        <input type="text" placeholder="Entrer la ville de livraison" name="ville" required />

        <label class="subtitle"><b>Pays</b></label>
        <input type="text" placeholder="Entrer le pays de livraison" name="pays" required>

        <label class="subtitle">Téléphone</label>
        <input type="text" minlength="10" maxlength="10" pattern="[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}-[0-9]{2}" title="poste" name="codePostal" placeholder="0610203040" required />

        <label class="subtitle"><b>Adresse email</b></label>
        <input type="email" placeholder="Entrer l'adresse mail de livraison" name="adresseMail" required />

        <div class="button">
            <button type="submit" class="btn2">Suivant</button>
        </div>
        -->
    </div>

    <?php include("./include/footer.php"); ?>

</body>

</html>