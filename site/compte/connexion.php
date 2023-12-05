<html>
    <head>
        <title>Disguise'Hub</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="/~saephp11/css/general.css">
        <link rel="stylesheet" type="text/css" href="/~saephp11/css/compte.css">
        <script type="text/javascript" src="/~saephp11/include/fontawesome.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        
        <?php include("../include/header.php"); ?>

        <div class="forms">

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                <h1>Connexion</h1>
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required>
                <label for="mdp">Mot de passe</label>
                <input type="password" name="mdp" id="mdp" required>
                <input type="submit" value="Se connecter">
            </form>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                <h1>Inscription</h1>
                <label>Prénom</label>
                <input type="text" name="prenom" id="prenom" required>
                <label>Nom</label>
                <input type="text" name="nom" id="nom" required>
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required>
                <label for="mdp">Mot de passe</label>
                <input type="password" name="mdp" id="mdp" required>
                <label for="mdp2">Confirmer le mot de passe</label>
                <input type="password" name="mdp2" id="mdp2" required>
                <input type="submit" value="S'inscrire">
            </form>
            
        </div>

        <?php include("../include/footer.php"); ?>

    </body>
</html>