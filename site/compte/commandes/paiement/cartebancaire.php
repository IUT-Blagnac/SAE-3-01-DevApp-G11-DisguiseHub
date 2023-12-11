<html>

<head>
    <title>Disguise'Hub</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../../../css/general.css">
    <link rel="stylesheet" type="text/css" href="../../../css/compte/commandes/paiement/index.css">
    <script type="text/javascript" src="../../../include/fontawesome.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

    <?php include("../../../include/header.php"); ?>

    <div class="Paiement">

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">

            <h1>Paiement</h1>

            <label class="subtitle"><b>Nom du titulaire</b></label>
            <input type="text" placeholder="Entrer le nom du titulaire de la carte" name="nomCarte" required>

            <label class="subtitle"><b>Numéro de la carte</b></label>
            <input type="tel" minlength="16" maxlength="19" pattern="[0-9\s]{13,25}" title="numCarte" name="numCarte" autocomplete="cc-number" placeholder="XXXX XXXX XXXX XXXX" required />

            <label class="subtitle"><b>Date expiration</b></label>
            <input type="month" name="dateExpiration" required>

            <label class="subtitle"><b>Cryptogramme</b></label>
            <input type="text" minlength="3" maxlength="4" pattern="[0-9]" title="Cryptogramme" name="Cryptogramme" required />


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
                <button type="reset" class="btn1">Annuler</button>
                <button type="submit" class="btn2">Valider</button>
            </div>

        </form>

        <div class="image">
                <svg class="front" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                    <path fill="#08111E" d="M35.3,-29C47.9,-22.7,61.7,-11.4,60.5,-1.2C59.3,9,43.1,18,30.6,24.2C18,30.3,9,33.7,-2.8,36.5C-14.6,39.3,-29.3,41.6,-45.3,35.5C-61.2,29.3,-78.6,14.6,-73,5.5C-67.5,-3.6,-39.1,-7.2,-23.1,-13.4C-7.2,-19.6,-3.6,-28.5,3.9,-32.4C11.4,-36.3,22.7,-35.2,35.3,-29Z" transform="translate(100 100)" />
                </svg>
                </svg>
                <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                    <path fill="#DE6E22" d="M36.9,-19C53,-9.2,74.8,6.4,73.4,18.6C72.1,30.7,47.6,39.4,24.9,49.6C2.1,59.8,-19,71.5,-38.7,67.1C-58.4,62.7,-76.6,42.2,-81.1,19.4C-85.7,-3.4,-76.4,-28.5,-60.6,-38.2C-44.8,-47.9,-22.4,-42.3,-6,-37.5C10.4,-32.8,20.8,-28.8,36.9,-19Z" transform="translate(100 100)" />
                </svg>
                <svg class="back" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                    <path fill="#7E3307" d="M43.1,-40C56.5,-29.7,68.4,-14.8,67.7,-0.7C67,13.5,53.7,27,40.4,35.5C27,43.9,13.5,47.4,-3,50.5C-19.5,53.5,-39.1,56.1,-52.8,47.6C-66.4,39.1,-74.2,19.5,-74.3,-0.1C-74.4,-19.7,-66.7,-39.3,-53,-49.7C-39.3,-60,-19.7,-61,-2.4,-58.6C14.8,-56.2,29.7,-50.4,43.1,-40Z" transform="translate(100 100)" />
                </svg>
            </div>
    </div>

    <?php include("../../../include/footer.php"); ?>

    <script>
        document.getElementsByName("numCarte")[0].addEventListener("input", function() {

            this.value = this.value.replace(/[^0-9]/g, "");
            this.value = this.value.replace(/(.{4})/g, "$1 ");

        });
    </script>

</body>

</html>