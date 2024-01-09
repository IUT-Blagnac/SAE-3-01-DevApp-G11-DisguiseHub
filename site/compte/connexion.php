<html>
    <head>
        <title>Connexion - Disguise'Hub</title>
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

        <?php include("../include/header.php"); ?>

        <div class="content">

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
    
                <h1>Connexion</h1>

                <?php
                    // Si le formulaire a été envoyé
                    if ($_SERVER["REQUEST_METHOD"] === "POST") {

                        // Vérification du captcha
                        $captchaResponse = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . urlencode("6LcVtiYpAAAAAN67ABYjhvYyA5km1oeqcsLgamlt") .  "&response=" . urlencode($_POST["g-recaptcha-response"])), true);
                        
                        if(isset($_POST["g-recaptcha-response"]) && $captchaResponse["success"]) {
                            
                            // Vérification des champs
                            if (isset($_POST["email"]) && isset($_POST["mdp"])) {

                                require_once("../include/connect.inc.php");

                                $email = $_POST["email"];
                                $mdp = $_POST["mdp"];
                                
                                $sql = "SELECT idClient, mdpClient FROM Client WHERE mailClient = :email";
                                $req = $conn -> prepare($sql);
                                $req -> execute(["email" => $email]);

                                // Si compte trouvé
                                if($req && $req->rowCount() == 1) {
                                    $user = $req -> fetch();

                                    // Si le mot de passe est correct
                                    if (password_verify($mdp, $user["mdpClient"])) {

                                        // Si se souvenir de moi
                                        if (isset($_POST["souvenir"])) {
                                            setcookie("sesouvenir", $email, time() + 365*24*3600);
                                        } else {
                                            setcookie("sesouvenir", "", time() - 3600);
                                        }

                                        // Connexion et redirection
                                        session_start();
                                        $_SESSION["connexion"] = $user["idClient"];
                                        header("Location: ./");

                                    // Si le mot de passe est incorrect
                                    } else {
                                        echo "<div class='msg erreur'>Mot de passe incorrect</div>";
                                    }
                                
                                // Si aucun compte n'est associé à l'adresse email
                                } else if ($req && $req->rowCount() == 0) {
                                    echo "<div class='msg erreur'>Adresse email inconnue</div>";
                                
                                // Si plusieurs comptes sont associés à l'adresse email (ce qui ne devrait pas être possible)
                                } else {
                                    echo "<div class='msg erreur'>Une erreur est survenue</div>";
                                }
                            
                            // Si captcha invalide
                            } else {
                                echo "<div class='msg erreur'>Captcha invalide</div>";
                            }
                        }
                    
                    // Si l'utilisateur vient de s'inscrire
                    } else if ($_SERVER["REQUEST_METHOD"] === "GET") {
                        if (isset($_GET["inscription"])) {
                            echo "<div class='msg succes'>Inscription réussie</div>";
                        } else if (isset($_GET["deconnexion"])) {
                            echo "<div class='msg succes'>Déconnexion réussie</div>";
                        } else if (isset($_GET["mdpoublie"])) {
                            echo "<div class='msg succes'>Mot de passe modifié</div>";
                        }
                    }
                ?>
    
                <label for="email">Email</label>
                <input type="email" name="email" id="email" autocomplete="email" value="<?php if(isset($_COOKIE["sesouvenir"])) { echo $_COOKIE["sesouvenir"]; }?>" required>
    
                <label for="mdp">Mot de passe</label>
                <input type="password" name="mdp" id="mdp" autocomplete="current-password" required>
                <a class="mdpoublie" href="/~saephp11/mdpoublie.php">Mot de passe oublié ?</a>

                <label class="checkbox">
                    <input type="checkbox" name="souvenir" <?php if(isset($_COOKIE["sesouvenir"])) { echo "checked"; }?>>
                    <svg width="20" height="20">
                        <polyline points="12 5 6.5 10.5 4 8"></polyline>
                    </svg>
                    Se souvenir de moi
                </label>
    
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
    
                <button type="submit" disabled>Se connecter</button>
                <a href="/~saephp11/compte/inscription.php">Je n'ai pas encore de compte</a>
    
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