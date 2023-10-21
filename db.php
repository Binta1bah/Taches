<?php
// Connexion à la base de donnée 
try {
    $connexion = new PDO("mysql:host=localhost;dbname=gestionTaches", "root", "");
    // echo "La connexion a reussi";
} catch (PDOException $e) {
    echo "La connexion a echoué" . $e->getMessage();
}
