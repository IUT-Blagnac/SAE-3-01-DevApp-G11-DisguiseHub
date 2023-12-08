<?php

// Génération de données aléatoires
require_once '\vendor\autoload.php';

$faker = Faker\Factory::create('fr_FR');

// Connexion à la base de données
$pdo = new PDO('mysql:host=localhost;dbname=saemysql11', 'saemysql11', 'J437ywnHdRA53c');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

for ($i = 0; $i < 10; $i++) {
    $numCB = $faker->creditCardNumber;
    $nomCB = $pdo -> exec("SELECT nom FROM Client WHERE numCB = $numCB");
    $dateExpCB = $faker->creditCardExpirationDateString;
    $cryptoCB = $faker->creditCardCvv;

    $pdo->exec("INSERT INTO CB (numCB, nomCB, dateExpCB, cryptoCB) VALUES ('$numCB', '$nomCB', '$dateExpCB', '$cryptoCB')");
}
