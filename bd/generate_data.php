<?php

// Génération de données aléatoires
require_once 'C:\Users\Angelo\OneDrive - etu.univ-tlse2.fr\Documents\GitHub\SAE-3-01-DevApp-G11-DisguiseHub\vendor\autoload.php';

$faker = Faker\Factory::create('fr_FR');

// Connexion à la base de données
$pdo = new PDO('mysql:host=localhost;dbname=saemysql11', 'saemysql11', 'J437ywnHdRA53c');
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

    $imageUrls[] = "https://picsum.photos/360/360?image=" . ($i + 99999);
    $pdo->exec("UPDATE Produit SET imageProduit = '" . implode(',', $imageUrls) . "' WHERE refProduit = " . ($i + 99999));
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

// Fonction de génération de numéro de carte bancaire 
function generateFakeCreditCard()
{
    $faker = Faker\Factory::create('fr_FR');
    return $faker->creditCardNumber;
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

    // Génération d'au moins une commande pour certains clients
    if ($i % 3 === 0) {
        $nombreCommandes = $faker->numberBetween(1, 3); // Choisissez le nombre de commandes par client
        for ($j = 0; $j < $nombreCommandes; $j++) {
            $dateCommande = $faker->date($format = 'd-m-Y', $max = 'now');
            $fraisLivraison = $faker->randomFloat(2, 5, 20);
            $adrLivraison = $faker->streetAddress;
            $codePostalLivraison = $faker->postcode;
            $statutCommande = $faker->randomElement(['En cours', 'Expédiée', 'Livré']);

            // Insertion dans la table Commande
            $pdo->exec("INSERT INTO Commande (idClient, idPaiement, dateCommande, fraisLivraison, adrLivraison, codePostalLivraison, statutCommande)
                            VALUES ($i + 1, NULL, '$dateCommande', $fraisLivraison, '$adrLivraison', '$codePostalLivraison', '$statutCommande')");

            $lastCommandeId = $pdo->lastInsertId();

            // Ajout de produits à la commande
            $nombreProduitsCommande = $faker->numberBetween(3, 7); // Moyenne d'environ 5 produits par commande
            for ($k = 0; $k < $nombreProduitsCommande; $k++) {
                $refProduit = $faker->numberBetween(100000, 100049);
                $qteCommandee = $faker->numberBetween(1, 5); // Quantité supérieure à 1 pour certains produits

                // Insertion dans la table Commander
                $pdo->exec("INSERT INTO Commander (refProduit, idCommande, qteCommandee)
                                VALUES ($refProduit, $lastCommandeId, $qteCommandee)");
            }

            // Ajout du règlement associé à la commande
            $idTypePaiement = $faker->numberBetween(1, 3); // Choisissez le type de paiement (1: Carte Bleue, 2: PayPal, 3: Virement Bancaire)

            $numCB = null;
            // Pour une dizaine de clients, conservez les références de carte bancaire
            if ($i < 10) {
                $numCB = generateFakeCreditCard(); // À remplacer par votre propre méthode de génération de numéro de carte bancaire
            }

            $pdo->exec("INSERT INTO Paiement (numCB, idPaypal, idVirement)
                            VALUES ($numCB, NULL, NULL)");
            $lastPaiementId = $pdo->lastInsertId();
            $pdo->exec("UPDATE Commande SET idPaiement = $lastPaiementId WHERE idCommande = $lastCommandeId");
        }
    }
}


// Génération de catégories de produits pour des déguisements
$categories = [
    'Promotion' => ['Fantômes', 'Sorcières' => ['Homme', 'Enfant', 'Femme']],
    'Nouveautés' => ['Pères Noël', 'Lutins' => ['Homme', 'Enfant', 'Femme']],
    'Made in France' => ['Marvel', 'DC Comics' => ['Homme', 'Enfant', 'Femme']],
];

function insererCategorie($nomCategorie, $idCategoriePere = null)
{
    global $pdo;
    $pdo->exec("INSERT INTO Categorie (nomCategorie, idCategoriePere) VALUES ('$nomCategorie', $idCategoriePere)");
}

function affecterProduitsAuxCategories($idCategorie, $nombreProduits)
{
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

function genererCategories($categories, $idCategoriePere = null)
{
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



// Génération d'avis sur des produits
$nombreAvis = 20;

for ($i = 0; $i < $nombreAvis; $i++) {
    $refProduit = $faker->numberBetween(100000, 100049);
    $idClient = $faker->numberBetween(1, $nombreClients);

    $commentaire = $faker->sentence;
    $note = $faker->numberBetween(1, 5);

    // Insertion dans la table Avis
    $pdo->exec("INSERT INTO Avis (refProduit, idClient, commentaire, note)
                    VALUES ($refProduit, $idClient, '$commentaire', $note)");

    $lastAvisId = $pdo->lastInsertId();

    // Génération de réponses à certains avis
    if ($i % 2 === 0) {
        $nombreReponses = $faker->numberBetween(1, 3); // Choisissez le nombre de réponses par avis
        for ($j = 0; $j < $nombreReponses; $j++) {
            $idAvisPere = $lastAvisId;
            $commentaireReponse = $faker->sentence;

            // Insertion dans la table Avis
            $pdo->exec("INSERT INTO Avis (idAvisPere, refProduit, idClient, commentaire)
                            VALUES ($idAvisPere, $refProduit, $idClient, '$commentaireReponse')");
        }
    }
}
