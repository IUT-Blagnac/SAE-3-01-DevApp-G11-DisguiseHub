<?php
    $connexion = $_SESSION["connexion"];
    $sql = "SELECT * FROM Client WHERE idClient = :connexion";
    $req = $conn -> prepare($sql);
    $req -> execute(["connexion" => htmlspecialchars($connexion)]);
    if ($req -> rowCount() != 1) {
        echo "<script>alert('Erreur : Nous n\'avons pas pu vous connecter. Vous allez être redirigé vers la page de connexion.');</script>";
        session_destroy();
        header("location: connexion.php");
        exit;
    } else {
        $user = $req -> fetch();
    }
?>

<nav>
    <?php
        echo "<h3>" . $user["prenomClient"] . " " . $user["nomClient"] . "</h3>";
    ?>
    <div>
        <a href="/~saephp11/compte/">🏠 Mon compte</a>
        <a href="/~saephp11/compte/commandes">📦 Mes commandes</a>
        <a href="/~saephp11/compte/informations.php">📝 Mes informations</a>
        <a href="/~saephp11/compte/avis.php">✍️ Mes avis</a>
        <a href="/~saephp11/compte/favoris.php">❤️ Mes favoris</a>
        <a href="/~saephp11/compte/?deconnexion" style="margin-top: 20px;">🔒 Déconnexion</a>
        <?php
            if (isset($_COOKIE["sesouvenir"])) {
                echo "<a href='/~saephp11/compte/?sesouvenir'>❌ Ne plus se souvenir</a>";
            }
            if ($user["isAdmin"] == true) {
                echo "<a href='/~saephp11/compte/admin'>🔧 Administration</a>";
            }
        ?>
    </div>
</nav>

<script>
    var liens = document.querySelectorAll("nav a");
    for (var i = 0; i < liens.length; i++) {
        var lien = liens[i].href;
        lien = lien.substring(lien.indexOf("~saephp11/") + 10);
        if (window.location.href.includes(lien)) {
            for (var j = 0; j < liens.length; j++) {
                liens[j].classList.remove("active");
            }
            liens[i].classList.add("active");
        }
    }
</script>