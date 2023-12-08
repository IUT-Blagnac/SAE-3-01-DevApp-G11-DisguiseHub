<?php

// Génération de données aléatoires
require_once '\vendor\autoload.php';

$faker = Faker\Factory::create('fr_FR');

// Connexion à la base de données
$pdo = new PDO('mysql:host=localhost;dbname=saemysql11', 'saemysql11', 'J437ywnHdRA53c');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

for ($i = 0; $i < 40; $i++) {
    $nom = $faker->firstName;
    $prenom = $faker->lastName;
    $adresse = $faker->streetAddress;

    $ville = $faker->city;
    $codePostal = $faker->postcode;

    $civilite = $faker->randomElement(['H', 'F', 'Autre']);
    $dateNaissance = $faker->date($format = 'd-m-Y', $max = '01-01-2000');
    $tel = $faker->phoneNumber;
    $mail = strtolower($prenom) . '.' . strtolower($nom) . '@gmail.com';
    $mdp = password_hash('motdepasse', PASSWORD_BCRYPT);

    // Insertion dans la table Client
    $pdo->exec("INSERT INTO Client (nomClient, prenomClient, adresseClient, villeClient, codePostalClient, civiliteClient, dateNaissanceClient, telClient, mailClient, mdpClient) VALUES ('$nom', '$prenom', '$adresse', '$ville', '$codePostal', '$civilite', '$dateNaissance', '$tel', '$mail', '$mdp')");
}

for ($i = 0; $i < 10; $i++) {
    $nom = $faker->firstName;
    $prenom = $faker->lastName;
    $adresse = $faker->streetAddress;

    $ville = $faker->city;
    $codePostal = $faker->postcode;

    $civilite = $faker->randomElement(['H', 'F', 'Autre']);
    $dateNaissance = $faker->date($format = 'd-m-Y', $max = '01-01-2000');
    $tel = $faker->phoneNumber;
    $mail = strtolower($prenom) . '.' . strtolower($nom) . '@gmail.com';
    $mdp = password_hash('motdepasse', PASSWORD_BCRYPT);
    $numCB = $pdo->exec("SELECT numCB FROM CB ORDER BY RAND() LIMIT 1");


    $pdo->exec("INSERT INTO Client (nomClient, prenomClient, adresseClient, villeClient, codePostalClient, civiliteClient, dateNaissanceClient, telClient, mailClient, mdpClient, numCB) VALUES ('$nom', '$prenom', '$adresse', '$ville', '$codePostal', '$civilite', '$dateNaissance', '$tel', '$mail', '$mdp', '$numCB')");
}
