<?php

session_start();
if (!isset($_SESSION["connexion"])) {
    header("location: connexion.php");
    exit;
}

require_once("../include/connect.inc.php");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["changer_mot_de_passe"])) {
    $oldPassword = isset($_POST["old_password"]) ? $_POST["old_password"] : "";
    $newPassword = isset($_POST["new_password"]) ? $_POST["new_password"] : "";
    $confirmPassword = isset($_POST["confirm_password"]) ? $_POST["confirm_password"] : "";

    if (empty($oldPassword) || empty($newPassword) || empty($confirmPassword)) {
    } else {
        $sql = "SELECT mdpClient FROM Client WHERE idClient = :id";
        $req = $conn->prepare($sql);
        $req->execute(["id" => htmlspecialchars($_SESSION["connexion"])]);
        $row = $req->fetch();

        if ($row && password_verify($oldPassword, $row["mdpClient"])) {

            if ($newPassword === $confirmPassword) {

                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                $sqlUpdate = "UPDATE Client SET mdpClient = :newPassword WHERE idClient = :id";
                $reqUpdate = $conn->prepare($sqlUpdate);
                $reqUpdate->execute(["newPassword" => htmlspecialchars($hashedPassword), "id" => htmlspecialchars($_SESSION["connexion"])]);

                echo '<script>alert("Le mot de passe a bien été changé !"); window.location.href = "informations.php";</script>';
                exit;
            } else {
                echo '<script>alert("Les nouveaux mots de passe ne correspondent pas !");</script>';
            }
        } else {
            echo '<script>alert("Mot de passe actuel incorrect !");</script>';
        }
    }
}

?>

<html>

<head>
    <title>Mes informations - Disguise'Hub</title>
    <link rel="apple-touch-icon" sizes="180x180" href="/~saephp11/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/~saephp11/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/~saephp11/img/favicon/favicon-16x16.png">
    <meta name="theme-color" content="#DE6E22">
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../css/general.css">
    <link rel="stylesheet" type="text/css" href="../css/compte/menuCompte.css">
    <link rel="stylesheet" type="text/css" href="../css/compte/informations.css">
    <script type="text/javascript" src="../include/fontawesome.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <?php include("../include/header.php"); ?>

    <div class="content">
        <?php include("../include/menuCompte.php"); ?>

        <div class="informations-container">
            <div class="mdp_content">
                <h2>Changer de mot de passe</h2><br><br>

                <form method=" post" action="modification_mdp.php">
                    <label class="label_mdp">Ancien mot de passe</label>
                    <input type="password" name="old_password" required><br><br>

                    <label class="label_mdp">Nouveau mot de passe</label>
                    <input type="password" name="new_password" required><br><br>

                    <label class="label_mdp">Confirmer le nouveau mot de passe</label>
                    <input type="password" name="confirm_password" required><br><br><br>

                    <input type="submit" name="changer_mot_de_passe" value="Valider">
                </form>

            </div>
        </div>
    </div>

    <?php include("../include/footer.php"); ?>
</body>

</html>