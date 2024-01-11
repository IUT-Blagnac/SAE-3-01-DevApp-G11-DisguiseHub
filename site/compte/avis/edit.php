<html>
    <head>
        <title>Mes avis - Disguise'Hub</title>
        <link rel="apple-touch-icon" sizes="180x180" href="/~saephp11/img/favicon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/~saephp11/img/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/~saephp11/img/favicon/favicon-16x16.png">
        <meta name="theme-color" content="#DE6E22">
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="../../css/general.css">
        <link rel="stylesheet" type="text/css" href="../../css/compte/menuCompte.css">
        <link rel="stylesheet" type="text/css" href="../../css/compte/avis/edit.css">
        <script type="text/javascript" src="../../include/fontawesome.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>

        <?php include("../../include/header.php"); ?>

        <?php
            session_start();
            if(!isset($_SESSION["connexion"])) {
                header("Location: ../connexion.php");
                exit;
            }
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                $sql = "SELECT DISTINCT P.refProduit FROM Produit P, Commander Co, Commande C
                WHERE P.refProduit = Co.refProduit
                AND Co.idCommande = C.idCommande
                AND C.idClient = :id
                AND P.refProduit = :produit";
                $req = $conn->prepare($sql);
                $req->execute([
                    "id" => htmlspecialchars($_SESSION["connexion"]),
                    "produit" => htmlspecialchars($_POST["id"])
                ]);
                $avi = $req->fetch();
                if ($req->rowCount() == 0) {
                    header("Location: ../avis");
                    exit;
                }
                $sql = "SELECT * FROM Avis WHERE refProduit = :produit AND idClient = :id";
                $req = $conn->prepare($sql);
                $req->execute([
                    "produit" => htmlspecialchars($_POST["id"]),
                    "id" => htmlspecialchars($_SESSION["connexion"])
                ]);
                $avi = $req->fetch();
                if ($req->rowCount() != 1) {
                    $sql = "INSERT INTO Avis (idClient, refProduit, note, commentaire)
                    VALUES (:idClient, :refProduit, :note, :commentaire)";
                    $req = $conn->prepare($sql);
                    $req->execute([
                        "idClient" => htmlspecialchars($_SESSION["connexion"]),
                        "refProduit" => htmlspecialchars($_POST["id"]),
                        "note" => htmlspecialchars($_POST["note"]),
                        "commentaire" => htmlspecialchars($_POST["commentaire"])
                    ]);
                } else {
                    if (isset($_POST["supprimer"])) {
                        $sql = "DELETE FROM Avis WHERE idClient = :id AND refProduit = :produit";
                        $req = $conn->prepare($sql);
                        $req->execute([
                            "id" => htmlspecialchars($_SESSION["connexion"]),
                            "produit" => htmlspecialchars($_POST["id"])
                        ]);
                        header("Location: ../avis");
                        exit;
                    }
                    $sql = "UPDATE Avis SET note = :note, commentaire = :commentaire WHERE idClient = :id AND refProduit = :produit";
                    $req = $conn->prepare($sql);
                    $req->execute([
                        "note" => htmlspecialchars($_POST["note"]),
                        "commentaire" => htmlspecialchars($_POST["commentaire"]),
                        "id" => htmlspecialchars($_SESSION["connexion"]),
                        "produit" => htmlspecialchars($_POST["id"])
                    ]);
                }
                if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
                    $sql = "SELECT * FROM Avis WHERE idAvis = :id";
                    $req = $conn->prepare($sql);
                    $req->execute(["id" => $_POST["id"]]);
                    $avi = $req->fetch();
                    $target_dir = "/home/saephp11/public_html/img/avis/";
                    $target_file = $target_dir . basename($_FILES["image"]["name"]);
                    $uploadOk = 1;
                    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                    $check = getimagesize($_FILES["image"]["tmp_name"]);
                    if ($check !== false) {
                        $uploadOk = true;
                    } else {
                        $uploadOk = false;
                    }
                    if (file_exists($target_file)) {
                        $uploadOk = false;
                    }
                    if ($_FILES["image"]["size"] > 500000) {
                        $uploadOk = false;
                    }
                    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                        $uploadOk = false;
                    }
                    if (!$uploadOk) {
                        echo "<script>alert('Une erreur est survenue lors de l'envoi de l'image.')</script>";
                    } else {
                        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                            $sql = "UPDATE Avis SET imageAvis = :image WHERE idClient = :id AND refProduit = :produit";
                            $req = $conn->prepare($sql);
                            $req->execute([
                                "image" => "/~saephp11/img/avis/" . htmlspecialchars($_FILES["image"]["name"]),
                                "id" => htmlspecialchars($_SESSION["connexion"]),
                                "produit" => htmlspecialchars($_POST["id"])
                            ]);
                        } else {
                            echo "<script>alert('Une erreur est survenue lors de l'envoi de l'image.')</script>";
                        }
                    }
                }
                header("Location: ../avis");
                exit;
            }
        ?>

        <div class="content">
            <?php include("../../include/menuCompte.php"); ?>

            <div>
                <?php
                    $sql = "SELECT DISTINCT P.refProduit FROM Produit P, Commander Co, Commande C
                    WHERE P.refProduit = Co.refProduit
                    AND Co.idCommande = C.idCommande
                    AND C.idClient = :id
                    AND P.refProduit = :produit";
                    $req = $conn->prepare($sql);
                    $req->execute([
                        "id" => $_SESSION["connexion"],
                        "produit" => $_GET["id"]
                    ]);
                    if ($req->rowCount() == 0) {
                        echo "<h2>Erreur</h2>
                        <p>Vous ne pouvez pas laisser d'avis sur un produit que vous n'avez pas acheté.</p>
                        <a class='button' href='/~saephp11/compte/avis'>Retour</a>";
                    } else if ($req->rowCount() != 1) {
                        echo $req->rowCount();
                        echo "<h2>Erreur</h2>
                        <p>Une erreur est survenue.</p>
                        <a class='button' href='/~saephp11/compte/avis'>Retour</a>";
                    } else {
                        $sql = "SELECT DISTINCT P.refProduit FROM Produit P, Commander Co, Commande C
                        WHERE P.refProduit = Co.refProduit
                        AND Co.idCommande = C.idCommande
                        AND C.idClient = :id
                        AND P.refProduit = :produit
                        AND P.refProduit NOT IN (
                            SELECT refProduit FROM Avis A
                            WHERE A.idClient = C.idClient
                        )";
                        $req = $conn->prepare($sql);
                        $req->execute([
                            "id" => $_SESSION["connexion"],
                            "produit" => $_GET["id"]
                        ]);
                        if (isset($_GET["supprimer"])) {
                            $status = "supprimer";
                            echo "<h2>Supprimer un avis</h2>";
                        } else if ($req->rowCount() == 0) {
                            $status = "modifier";
                            echo "<h2>Modifier un avis</h2>";
                        } else {
                            $status = "ajouter";
                            echo "<h2>Ajouter un avis</h2>";
                        }
                        $sql = "SELECT * FROM Produit WHERE refProduit = :id";
                        $req = $conn->prepare($sql);
                        $req->execute(["id" => $_GET["id"]]);
                        $produit = $req->fetch();
                        $sql = "SELECT * FROM Avis WHERE idClient = :id AND refProduit = :produit";
                        $req = $conn->prepare($sql);
                        $req->execute([
                            "id" => $_SESSION["connexion"],
                            "produit" => $_GET["id"]
                        ]);
                        $avi = $req->fetch();

                        echo "<div class='avis'>
                            <form class='avi' action='edit.php' method='POST' enctype='multipart/form-data'>
                                <input type='hidden' name='id' value='" . $_GET["id"] . "'>";
                                if (isset($_GET["supprimer"])) {
                                    echo "<input type='hidden' name='supprimer' value='1'>";
                                }
                                echo "<div>
                                    <div class='inputs'>
                                        <div class='note'>
                                            <label for='note'>Note :</label>";
                                            if (isset($_GET["supprimer"])) {
                                                echo "<input type='text' name='note' value='";
                                                for ($i = 0; $i < $avi["note"]; $i++) {
                                                    echo "⭐";
                                                }
                                                echo "' readonly required>";
                                            } else {
                                                echo "<select name='note' required " . ((isset($_GET["supprimer"] )) ? "disabled" : "") . ">
                                                    <option selected disabled></option>";
                                                    for ($i = 1; $i <= 5; $i++) {
                                                        echo "<option value='" . $i . "' " . (($avi["note"] == $i) ? "selected" : "") . ">";
                                                        for ($j = 0; $j < $i; $j++) {
                                                            echo "⭐";
                                                        }
                                                        echo "</option>";
                                                    }
                                                echo "</select>";
                                            }
                                        echo "</div>
                                        <div class='texte'>
                                            <label for='commentaire'>Commentaire :</label>
                                            <textarea name='commentaire' " . ((isset($_GET["supprimer"] )) ? "readonly" : "") . " required>" . ((isset($avi["commentaire"]) ? $avi["commentaire"] : "")) . "</textarea>
                                        </div>
                                    </div>
                                    <div class='image' " . ((isset($_GET["supprimer"] )) ? "style='min-width: 0;''" : "") . " >";
                                        if (isset($avi["imageAvis"])) {
                                            echo "<img id='image' src='" . $avi["imageAvis"] . "' alt='Votre image d'avis'>";
                                        }
                                        if (!isset($_GET["supprimer"])) {
                                            echo "<label>
                                                <input type='file' name='image' style='display: none;' id='inputimage' accept='image/*'>";
                                                if (isset($avi["imageAvis"])) {
                                                    echo "<i class='fa fa-cloud-upload'></i> Mettre à jour l'image";
                                                } else {
                                                    echo "<i class='fa fa-cloud-upload'></i> Ajouter une image";
                                                }
                                                // TODO: Image ne fonctionne pas
                                                echo "<script>
                                                    document.getElementById('inputimage').onchange = function(this) {
                                                        alert('test');
                                                        if (!document.getElementById('image')) {
                                                            var image = document.createElement('img');
                                                            image.id = 'image';
                                                            image.alt = 'Votre image d'avis';
                                                            document.getElementsByClassName('image')[0].appendChild(image);
                                                        }
                                                        if (this.files[0]) {
                                                            document.getElementById('image').src = URL.createObjectURL(this.files[0]);
                                                        }
                                                    };
                                                </script>
                                            </label>";
                                        }
                                    echo "</div>
                                </div>
                                <div>
                                    <a class='button retour' href='/~saephp11/compte/avis'>Retour</a>";
                                    if ($status == "modifier") {
                                        echo "<a class='button supprimer' href='/~saephp11/compte/avis/edit.php?id=" . $_GET["id"] . "&supprimer'>Supprimer</a>";
                                    }
                                    echo "<button type='submit'>Valider</button>
                                </div>
                            </form>";
                            require_once("../../include/apercuProduit.php");
                        echo "</div>";
                    }
                ?>
            </div>
        </div>

        <?php include("../../include/footer.php"); ?>

    </body>
</html>