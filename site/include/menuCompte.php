<?php
session_start();
if (!isset($_SESSION["connexion"])) {
    header("location: connexion.php");
    exit;
} else {
    $connexion = $_SESSION["connexion"];
    $sql = "SELECT * FROM Client WHERE idClient = :connexion";
    $req = $conn->prepare($sql);
    $req->execute(["connexion" => htmlspecialchars($connexion)]);
    $user = $req->fetch();
}
?>

<nav>
    <?php
    echo "<h3>" . $user["prenomClient"] . " " . $user["nomClient"] . "</h3>";
    ?>
    <div>
        <a href="./">🏠 Mon compte</a>
        <a href="./commandes.php">📦 Mes commandes</a>
        <a href="./informations.php">📝 Mes informations</a>
        <a href="./avis.php">✍️ Mes avis</a>
        <a href="./favoris.php">❤️ Mes favoris</a>
        <a href="./?deconnexion" style="margin-top: 20px;">🔒 Déconnexion</a>
        <?php
        if ($user["isAdmin"] == true) {
            echo "<a href='./admin'>🔧 Administration</a>";
        }
        ?>
    </div>
</nav>