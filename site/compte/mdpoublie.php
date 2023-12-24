<html>
    <head>
        <title>Mot de passe oublié - Disguise'Hub</title>
    <link rel="apple-touch-icon" sizes="180x180" href="/~saephp11/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/~saephp11/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/~saephp11/img/favicon/favicon-16x16.png">
    <meta name="theme-color" content="#DE6E22">
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="../css/general.css">
        <link rel="stylesheet" type="text/css" href="../css/compte/connexion-inscription.css">
        <script type="text/javascript" src="../include/fontawesome.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>

        <?php
            session_start();
            // Si l'utilisateur est déjà connecté
            if (isset($_SESSION["connexion"])) {
                header("Location: ./");
                exit();
            }
        ?>
        
        <?php include("../include/header.php"); ?>

        <div class="content">

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">

                <h1>Mot de passe oublié</h1>
                <p>Afin de modifier votre mot de passe, veuillez entrez les informations de votre compte pour le retrouver. En cas d'erreur, aucune modification ne sera faite sur votre mot de passe.</p>

                <?php
                    // Si le formulaire a été envoyé
                    if ($_SERVER["REQUEST_METHOD"] === "POST") {

                        // Vérification du captcha
                        $captchaResponse = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . urlencode("6LcVtiYpAAAAAN67ABYjhvYyA5km1oeqcsLgamlt") .  "&response=" . urlencode($_POST["g-recaptcha-response"])), true);
                                    
                        if(isset($_POST["g-recaptcha-response"]) && $captchaResponse["success"]) {


                            if (isset($_POST["prenom"]) && isset($_POST["nom"]) && isset($_POST["dtn"]) && isset($_POST["email"]) && isset($_POST["tel"])) {

                                require_once("../include/connect.inc.php");

                                $prenom = $_POST["prenom"];
                                $nom = $_POST["nom"];
                                $dtn = $_POST["dtn"];
                                $email = $_POST["email"];
                                $tel = $_POST["tel"];
                                $mdp = $_POST["mdp"];

                                $sql = "SELECT * FROM Client WHERE prenomClient = :prenom AND nomClient = :nom AND dateNaissanceClient = :dtn AND mailClient = :email AND telClient = :tel";
                                $req = $conn -> prepare($sql);
                                $req -> execute([
                                    "prenom" => $prenom,
                                    "nom" => $nom,
                                    "dtn" => $dtn,
                                    "email" => $email,
                                    "tel" => $tel
                                ]);

                                // Si aucun compte trouvé
                                if($req && $req->rowCount() == 0) {
                                    echo "<div class='msg erreur'>Aucun compte trouvé, réessayez</div>";

                                // Si plusieurs comptes trouvés
                                } else if ($req && $req->rowCount() > 1) {
                                    echo "<div class='msg erreur'>Une erreur est survenue</div>";

                                } else {

                                    // Si compte est administrateur ignorer
                                    if ($req -> fetch()["isAdmin"] == 1) {
                                        echo "<div class='msg erreur'>Pour des raisons de sécurité, il n'est pas possible de modifier le mot de passe d'un compte administrateur. Veuillez accéder à la base de données directement.</div>";
                                    
                                    // Modification du mot de passe
                                    } else {
                                        
                                        $mdp = password_hash($mdp, PASSWORD_DEFAULT);
                                        
                                        $sql = "UPDATE Client SET mdpClient = :mdp WHERE prenomClient = :prenom AND nomClient = :nom AND dateNaissanceClient = :dtn AND mailClient = :email AND telClient = :tel";
                                        $req = $conn->prepare($sql);
                                        $succes = $req->execute([
                                            "mdp" => $mdp,
                                            "prenom" => htmlspecialchars($prenom),
                                            "nom" => htmlspecialchars($nom),
                                            "dtn" => htmlspecialchars($dtn),
                                            "email" => htmlspecialchars($email),
                                            "tel" => htmlspecialchars($tel)
                                        ]);

                                        // Si création réussie
                                        if ($succes) {
                                            header("Location: ./connexion.php?mdpoublie");
                                        
                                        // Si création échouée
                                        } else {
                                            echo "<div class='msg erreur'>Erreur lors de la modification du mot de passe</div>";
                                        }
                                    }
                                                                    
                                }
                                
                                // Si tous les champs ne sont pas remplis
                            } else {
                                echo "<div class='msg erreur'>Veuillez remplir tous les champs</div>";
                            }
                            
                        
                        // Si captcha invalide
                        } else {
                            echo "<div class='msg erreur'>Captcha invalide</div>";
                        }

                    }
                ?>

                <label for="prenom">Prénom</label>
                <input type="text" name="prenom" id="prenom" autocomplete="given-name" required>

                <label for="nom">Nom</label>
                <input type="text" name="nom" id="nom" autocomplete="family-name" required>

                <label for="dtn">Date de naissance</label>
                <input type="date" name="dtn" id="dtn" max="<?php echo date('Y-m-d'); ?>" autocomplete="bday" required>

                <label for="email">Email</label>
                <input type="email" name="email" id="email" autocomplete="email" required>

                <label for="email">Téléphone</label>
                <input type="tel" name="tel" id="tel" autocomplete="tel" oninput="this.value = this.value.replace(/[^0-9+.-]/g, '')" required>

                <label for="mdp">Nouveau mot de passe</label>
                <input type="password" name="mdp" id="mdp" autocomplete="new-password" pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*\W).{8,}" required>
                
                <span class="minuscule">Une lettre minuscule</span>
                <span class="majuscule">Une lettre majuscule</span>
                <span class="chiffre">Un chiffre</span>
                <span class="special">Un caractère spécial</span>
                <span class="caracteres">Minimum 8 caractères</span>
                
                <script type="text/javascript">
                    document.getElementById("mdp").onkeyup = function() {
                        if(document.getElementById("mdp").value.match(/[a-z]/g)) {
                            document.querySelector("span.minuscule").classList.add("ok");
                        } else {
                            document.querySelector("span.minuscule").classList.remove("ok");
                        }

                        if(document.getElementById("mdp").value.match(/[A-Z]/g)) {
                            document.querySelector("span.majuscule").classList.add("ok");
                        } else {
                            document.querySelector("span.majuscule").classList.remove("ok");
                        }

                        if(document.getElementById("mdp").value.match(/(?=.*\d)/g)) {
                            document.querySelector("span.chiffre").classList.add("ok");
                        } else {
                            document.querySelector("span.chiffre").classList.remove("ok");
                        }

                        if(document.getElementById("mdp").value.match(/(?=.*\W)/g)) {
                            document.querySelector("span.special").classList.add("ok");
                        } else {
                            document.querySelector("span.special").classList.remove("ok");
                        }

                        if(document.getElementById("mdp").value.length >= 8) {
                            document.querySelector("span.caracteres").classList.add("ok");
                        } else {
                            document.querySelector("span.caracteres").classList.remove("ok");
                        }
                    }
                </script>

                <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                <div class="g-recaptcha" data-sitekey="6LcVtiYpAAAAABGS6Bzi7lBAusEvDUgaLCcQgaKT" data-callback="captcha" data-expired-callback="captchaExpired"></div>

                <script type="text/javascript">
                    function captcha() {
                        document.querySelector("button[type=submit]").disabled = false;
                    }

                    function captchaExpired() {
                        document.querySelector("button[type=submit]").disabled = true;
                    }
                </script>

                <button type="submit" disabled>Modifier mon mot de passe</button>
                <a href="connexion.php">Annuler</a>

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

        <?php include("../include/footer.php"); ?>

    </body>
</html>