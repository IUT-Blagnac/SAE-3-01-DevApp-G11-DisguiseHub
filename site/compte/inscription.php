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

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">

            <h1>Inscription</h1>

            <label for="prenom">Prénom</label>
            <input type="text" name="prenom" id="prenom" required>

            <label for="nom">Nom</label>
            <input type="text" name="nom" id="nom" required>

            <label for="genre">Genre</label>
            <select>
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
                <option>Femme cisgenre</option>
                <option>Homme cisgenre</option>
                <option>Genre fluide</option>
                <option>Genre non conformiste</option>
                <option>Homme à Femme</option>
                <option>MTF</option>
                <option>Neutrois</option>
                <option>Ni l'un ni l'autre</option>
                <option>Non-binaire</option>
                <option>Pangender</option>
                <option>Personne trans</option>
                <option>Personne transgenre</option>
                <option>Questionnement sur le genre</option>
                <option>Trans</option>
                <option>Trans*</option>
                <option>Trans Femme</option>
                <option>Trans* Femme</option>
                <option>Trans Homme</option>
                <option>Trans* Homme</option>
                <option>Homme trans</option>
                <option>Homme trans*</option>
                <option>Homme transgenre</option>
                <option>Homme transsexuel</option>
                <option>Intersexe</option>
                <option>Transgenre</option>
                <option>Transgender Female</option>
                <option>Transgender Male</option>
                <option>Personne transgenre</option>
                <option>Femme trans</option>
                <option>Femme trans*</option>
                <option>Femme transgenre</option>
                <option>Femme transsexuelle</option>
                <option>Transféminin</option>
                <option>Transmasculin</option>
                <option>Transsexuel</option>
                <option>Transsexuel Femme</option>
                <option>Transsexuel Homme</option>
                <option>Double esprit</option>
                <option>Autre</option>
            </select>

            <label for="email">Email</label>
            <input type="email" name="email" id="email" required>

            <label for="mdp">Mot de passe</label>
            <input type="password" name="mdp" id="mdp" required>

            <script src="https://www.google.com/recaptcha/api.js" async defer></script>
            <div class="g-recaptcha" data-sitekey="6LcVtiYpAAAAABGS6Bzi7lBAusEvDUgaLCcQgaKT"></div>

            <button type="submit" disabled>S'inscrire</button>
            <a href="connexion.php">J'ai déjà un compte</a>

        </form>

        <?php include("../include/footer.php"); ?>

    </body>
</html>