<html>
    <head>
        <title>Connexion - Disguise'Hub</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="/~saephp11/css/general.css">
        <link rel="stylesheet" type="text/css" href="/~saephp11/css/connexion.css">
        <script type="text/javascript" src="/~saephp11/include/fontawesome.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        
        <?php include("../include/header.php"); ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">

            <h1>Connexion</h1>

            <label for="email">Email</label>
            <input type="email" name="email" id="email" required>

            <label for="mdp">Mot de passe</label>
            <input type="password" name="mdp" id="mdp" required>

            <script src="https://www.google.com/recaptcha/api.js" async defer></script>
            <div class="g-recaptcha" data-sitekey="6LcVtiYpAAAAABGS6Bzi7lBAusEvDUgaLCcQgaKT" data-callback="captcha(false)" data-expired-callback="captcha(true)"></div>

            <button type="submit" disabled>Se connecter</button>
            <a href="inscription.php">Je n'ai pas encore de compte</a>
        </form>

        <script type="text/javascript">
            function captcha(status) {
                alert("Test");
                document.querySelector("button[type=submit]").disabled = status;
            }
        </script>

        <?php include("../include/footer.php"); ?>

    </body>
</html>