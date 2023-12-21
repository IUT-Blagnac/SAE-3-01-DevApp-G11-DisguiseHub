<?php

if (isset($_POST['payer'])) {
    $paiement = $_POST['paiement'];
    if ($paiement == "cb") {
        header("Location: paiement/cartebancaire.php");
    } else if ($paiement == "paypal") {
        header("Location: paiement/paypal.php");
    } else if ($paiement == "virement") {
        header("Location: virement.php");
    }
}
?>

<html>

<head>
    <title>Paiement - Disguise'Hub</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../../css/general.css">
    <link rel="stylesheet" type="text/css" href="../../css/compte/commandes/paiement/moyenpaiement.css">
    <script type="text/javascript" src="../../include/fontawesome.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <?php include("../../include/header.php"); ?>


    <div class="content">
        <h1>Choisissez votre moyen de paiement</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="input">
                <input type="radio" class="ignore" id="cb" name="paiement" value="cb" required>
                <label for="cb">
                    <i class="fa-solid fa-credit-card fa-2x"></i>
                    <a>Carte bancaire</a>
                </label>
            </div>
            <div class="input">
                <input type="radio" class="ignore" id="paypal" name="paiement" value="paypal" required>
                <label for="paypal">
                    <i class="fa-brands fa-cc-paypal fa-2x"></i>
                    <a>Paypal</a>
                </label>
            </div>
            <div class="input">
                <input type="radio" class="ignore" id="virement" name="paiement" value="virement" required>
                <label for="virement">
                    <i class="fa-solid fa-building-columns fa-2x"></i>
                    <a>Virement bancaire</a>
                </label>
            </div>
            <button type="submit" name="payer">Payer</button>
        </form>
    </div>

    <?php include("../../include/footer.php"); ?>


</body>

</html>