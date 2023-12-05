<?php

    // Génération de données aléatoires
    require_once 'vendor/autoload.php';

    $faker = Faker\Factory::create('fr_FR');

    // Connexion à la base de données
    $pdo = new PDO('mysql:host=localhost;dbname=saemysql11  ', 'saemysql11  ', 'J437ywnHdRA53c');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    // Génération de 50 produits
    for ($i = 1; $i <= 50; $i++) {
        $sql = "INSERT INTO Produit (idCategorie, nomProduit, descProduit, prixProduit, qteProduit, tailleProduit, couleurProduit)
                VALUES (:idCategorie, :nomProduit, :descProduit, :prixProduit, :qteProduit, :tailleProduit, :couleurProduit)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'idCategorie' => $faker->numberBetween(1, 12), // Assurez-vous d'adapter cette plage en fonction de vos catégories
            'nomProduit' => $faker->unique()->word,
            'descProduit' => $faker->sentence,
            'prixProduit' => $faker->randomFloat(2, 10, 500),
            'qteProduit' => $faker->randomNumber(2),
            'tailleProduit' => $faker->randomElement(['XS', 'S', 'M', 'L', 'XL', 'XXL']),
            'couleurProduit' => $faker->colorName,
        ]);

        if ($i % 6 == 0) {
            $composition = [];
            // Sélectionner aléatoirement 3 produits existants pour la composition
            for ($j = 0; $j < 3; $j++) {
                $composition[] = $faker->numberBetween(100000, $i + 99999);
            }
    
            // Insérer la composition dans la table des produits composés
            $sqlComposition = "INSERT INTO ProduitCompose (refProduitCompose, composition)
                                VALUES (:refProduitCompose, :composition)";
            $stmtComposition = $pdo->prepare($sqlComposition);
            $stmtComposition->execute([
                'refProduitCompose' => $i + 99999,
                'composition' => implode(',', $composition),
            ]);
        }
    }


    // Génération de couples de produits apparentés
    $nombreCouples = 25;

    for ($i = 0; $i < $nombreCouples; $i++) {
        // Sélection aléatoire de deux produits distincts
        $produit1 = $faker->numberBetween(100000, 100049);
        $produit2 = $faker->numberBetween(100000, 100049);

        // les deux produits sont distincts
        while ($produit2 === $produit1) {
            $produit2 = $faker->numberBetween(100000, 100049);
        }

        // Insertion dans la table ProduitApparente
        $pdo->exec("INSERT INTO ProduitApparente (refProduit1, refProduit2) VALUES ($produit1, $produit2)");
    }
    

    // Génération de clients en France
    $nombreClients = 50;

    for ($i = 0; $i < $nombreClients; $i++) {
        $nom = $faker->firstName;
        $prenom = $faker->lastName;
        $adresse = $faker->streetAddress;
        
        $ville = $faker->city;
        $codePostal = $faker->postcode;

        $civilite = $faker->randomElement(['H', 'F']);
        $dateNaissance = $faker->date($format = 'd-m-Y', $max = '01-01-2000');
        $tel = $faker->phoneNumber;
        $mail = strtolower($prenom) . '.' . strtolower($nom) . '@gmail.com';
        $mdp = password_hash('motdepasse', PASSWORD_BCRYPT); 

        // Insertion dans la table Client
        $pdo->exec("INSERT INTO Client (nomClient, prenomClient, adresseClient, villeClient, codePostalClient, civiliteClient, dateNaissanceClient, telClient, mailClient, mdpClient) VALUES ('$nom', '$prenom', '$adresse', '$ville', '$codePostal', '$civilite', '$dateNaissance', '$tel', '$mail', '$mdp')");
    }


    // Génération de catégories de produits pour des déguisements
    $categories = [
        'Promotion' => ['Fantômes', 'Sorcières' => ['Homme', 'Enfant', 'Femme']],
        'Nouveautés' => ['Pères Noël', 'Lutins' => ['Homme', 'Enfant', 'Femme']],
        'Made in France' => ['Marvel', 'DC Comics' => ['Homme', 'Enfant', 'Femme']],
    ];

    function insererCategorie($nomCategorie, $idCategoriePere = null) {
        global $pdo;
        $pdo->exec("INSERT INTO Categorie (nomCategorie, idCategoriePere) VALUES ('$nomCategorie', $idCategoriePere)");
    }

    function affecterProduitsAuxCategories($idCategorie, $nombreProduits) {
        global $pdo, $faker;

        for ($i = 0; $i < $nombreProduits; $i++) {
            $sql = "INSERT INTO Produit (idCategorie, nomProduit, descProduit, prixProduit, qteProduit, tailleProduit, couleurProduit)
                    VALUES (:idCategorie, :nomProduit, :descProduit, :prixProduit, :qteProduit, :tailleProduit, :couleurProduit)";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'idCategorie' => $idCategorie,
                'nomProduit' => $faker->unique()->word,
                'descProduit' => $faker->sentence,
                'prixProduit' => $faker->randomFloat(2, 10, 500),
                'qteProduit' => $faker->randomNumber(2),
                'tailleProduit' => $faker->randomElement(['XS', 'S', 'M', 'L', 'XL', 'XXL']),
                'couleurProduit' => $faker->colorName,
            ]);

            if ($i % 6 == 0) {
                $composition = [];
                // Sélectionner aléatoirement 3 produits existants pour la composition
                for ($j = 0; $j < 3; $j++) {
                    $composition[] = $faker->numberBetween(100000, $i + 99999);
                }

                // Insérer la composition dans la table des produits composés
                $sqlComposition = "INSERT INTO ProduitCompose (refProduitCompose, composition)
                                    VALUES (:refProduitCompose, :composition)";
                $stmtComposition = $pdo->prepare($sqlComposition);
                $stmtComposition->execute([
                    'refProduitCompose' => $i + 99999,
                    'composition' => implode(',', $composition),
                ]);
            }
        }
    }

    function genererCategories($categories, $idCategoriePere = null) {
        global $pdo;

        foreach ($categories as $nomCategorie => $sousCategories) {
            insererCategorie($nomCategorie, $idCategoriePere);

            if (is_array($sousCategories)) {
                $lastId = $pdo->lastInsertId();
                genererCategories($sousCategories, $lastId);

                // Affecter des produits à cette catégorie
                affecterProduitsAuxCategories($lastId, 3); // Choisir le nombre de produits que vous souhaitez pour chaque catégorie
            }
        }
    }

    // Générer les catégories
    genererCategories($categories);







?>