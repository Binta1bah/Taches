<?php

session_start();
$_SESSION['user'] = array();

require_once('db.php');

if (isset($_POST['connexion'])) {
    $email = $_POST['email'];
    $passe = $_POST['passe'];
    //var_dump($passe);
    $erreursConn = [];
    if (empty($email) || empty($passe)) {
        echo "Les champs email et mot de passe sont obligatoires";
        $erreursConn[] = ["Les champs email et mot de passe sont obligatoires"];
    } elseif (!preg_match("/^[a-zA-Z0-9]+@[a-zA-Z]+\.[a-zA-Z]{2,}$/", $email)) {
        echo "Donner un email correct";
        $erreursConn[] = ["Donner un email correct"];
    } elseif (strlen($passe) !=  8) {
        echo "Le mot de passe doit contenir au moins 8 caracteres";
        $erreursConn[] = ["Le mot de passe doit contenir au moins 8 caracteres"];
    } else {

        //requette sql
        $query = (" SELECT * FROM `users` WHERE email = :mail AND motdepasse = :pass");
        $passcryp = md5($passe);

        $affiche = $connexion->prepare($query);

        $affiche->bindParam(':mail', $_POST['email']);
        $affiche->bindParam(':pass', $passcryp);

        $affiche->execute();

        $resutat = $affiche->fetchAll();
        //  var_dump($resutat);
        // die;

        $_SESSION['user'] = $resutat;

        if ($resutat) {
            header('location:acceuil.php');
            // echo "Ce compte existe";
        } else {
            echo "Ce compte n'existe pas";
        }
    }
}









?>







<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div id="div1">
        <h1 id="bien">Connexion</h1>

        <form action="" method="post">


            <div>
                <label for="">Adresse Email</label>
                <input class="tel" type="text" name="email" placeholder="Entrer votre email" value="<?php if (!empty($erreursConn)) echo $email ?>"><br>
            </div>

            <div>
                <label for="">Mot de Passe</label>
                <input class="tel" type="text" name="passe" placeholder="********" value="<?php if (!empty($erreursConn)) echo $passe ?>"><br>
                <br>

                <a href="modifPass.php">Mot de passe oublié ?</a>


            </div><br>



            <input id="ins2" type="submit" name="connexion" value="Se connecter">


        </form>
        <br>

        <a href="inscription.php" id="lien">Je n'ai pas de compte</a>

    </div>


</body>

</html>