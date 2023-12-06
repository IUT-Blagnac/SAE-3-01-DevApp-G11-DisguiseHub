<?php
    try {
        $conn = new PDO('mysql:host=localhost; dbname=saemysql11; charset=UTF8', 'saemysql11', 'J437ywnHdRA53c', [ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ]);
    } catch (PDOException $e) {
        echo "<b>Erreur :</b><br><pre>" . $e -> getMessage() . "</pre><br>" ;
        die();
    }
?>