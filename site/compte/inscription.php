<html>
    <head>
        <title>Inscription - Disguise'Hub</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="/~saephp11/css/general.css">
        <link rel="stylesheet" type="text/css" href="/~saephp11/css/connexion.css">
        <script type="text/javascript" src="/~saephp11/include/fontawesome.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        
        <?php include("../include/header.php"); ?>

        <div class="content">

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">

                <h1>Inscription</h1>

                <label for="prenom">Prénom</label>
                <input type="text" name="prenom" id="prenom" autocomplete="given-name" required>

                <label for="nom">Nom</label>
                <input type="text" name="nom" id="nom" autocomplete="family-name" required>

                <label for="genre">Genre</label>
                <select id="genre" name="genre">
                    <option disabled selected></option>
                    <option>Homme</option>
                    <option>Femme</option>
                    <option disabled></option>
                    <option>Agender</option>
                    <option>Androgyne</option>
                    <option>Androgynes</option>
                    <option>Babela</option>
                    <option>Bigender</option>
                    <option>Blagnac</option>
                    <option>Cis</option>
                    <option>Cis Femme</option>
                    <option>Cis Homme</option>
                    <option>Cis Man</option>
                    <option>Cis Woman</option>
                    <option>Cisgenre</option>
                    <option>Cisgender Female</option>
                    <option>Cisgender Male</option>
                    <option>Double esprit</option>
                    <option>Femme cisgenre</option>
                    <option>Femme trans</option>
                    <option>Femme trans*</option>
                    <option>Femme transgenre</option>
                    <option>Femme transsexuelle</option>
                    <option>Genre fluide</option>
                    <option>Genre non conformiste</option>
                    <option>Hélicoptère d'attaque</option>
                    <option>Homme cisgenre</option>
                    <option>Homme trans</option>
                    <option>Homme trans*</option>
                    <option>Homme transgenre</option>
                    <option>Homme transsexuel</option>
                    <option>Homme à Femme</option>
                    <option>Intersexe</option>
                    <option>Les crêpes de Marwan</option>
                    <option>MTF</option>
                    <option>Neutrois</option>
                    <option>Ni l'un ni l'autre</option>
                    <option>Non-binaire</option>
                    <option>Pangender</option>
                    <option>Personne trans</option>
                    <option>Personne transgenre</option>
                    <option>Personne transgenre</option>
                    <option>Questionnement sur le genre</option>
                    <option>Trans</option>
                    <option>Trans*</option>
                    <option>Trans Femme</option>
                    <option>Trans* Femme</option>
                    <option>Trans Homme</option>
                    <option>Trans* Homme</option>
                    <option>Transgender Female</option>
                    <option>Transgender Male</option>
                    <option>Transféminin</option>
                    <option>Transmasculin</option>
                    <option>Transsexuel</option>
                    <option>Transsexuel Femme</option>
                    <option>Transsexuel Homme</option>
                    <option>Transgenre</option>
                    <option>Transgenre</option>
                    <option>Transgender Female</option>
                    <option>Transgender Male</option>
                    <option disabled></option>
                    <option>Autre</option>
                </select>

                <label for="email">Email</label>
                <input type="email" name="email" id="email" autocomplete="email" required>

                <label for="mdp">Mot de passe</label>
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

                        if(document.getElementById("mdp").value.match(/[0-9]/g)) {
                            document.querySelector("span.chiffre").classList.add("ok");
                        } else {
                            document.querySelector("span.chiffre").classList.remove("ok");
                        }

                        if(document.getElementById("mdp").value.match(/[!@#$%^&*_=+-]/g)) {
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

                <button type="submit" disabled>S'inscrire</button>
                <a href="connexion.php">J'ai déjà un compte</a>

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