<?php 
if(isset($_POST["payer"])){
    $nom = $_POST["nom"];
    $iban = $_POST["iban"];
    $bic = $_POST["bic"];
    $montant = $_POST["montant"];
    $date = $_POST["date"];

    $sql = "INSERT INTO VirementBancaire (nom, iban, bic, montant, date) VALUES (:nom, :iban, :bic, :montant, :date)";

    $stmt = $conn->prepare($sql);
    $succes = $stmt->execute(["nom" => htmlspecialchars($nom), "iban" => htmlspecialchars($iban), "bic" => htmlspecialchars($bic), "montant" => htmlspecialchars($montant), "date" => htmlspecialchars($date)]);
}

?>

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

    <h1> Formulaire de virement </h1>
    <from action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        
            <label for="nom">Nom et Prénom</label>
            <input type="text" id="nom" name="nom" required>
      
            <label for="iban">IBAN</label>
            <input type="text" id="iban" name="iban" pattern="[A-Z0-9]+" required>
        
            <label for="bic">BIC</label>
            <input type="text" id="bic" name="bic" patter="[A-Z]+"required>
       
            <label for="montant">Montant</label>
            <input type="number" id="montant" name="montant" required>

            <label for="date">Date</label>
            <input type="date" id="date" name="date" required>
      
        <button type="submit" name="payer">Payer</button>
    </from>

    < <?php include("../../../include/footer.php"); ?> </body>

</html>