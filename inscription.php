<?php

require_once('db.php');



if (isset($_POST['inscription'])) {

    $nom = $_POST['nom'];
    $mail = $_POST['email'];
    $pass = $_POST['passe'];
    $Confirme = $_POST['confirme'];
    $erreursIns = [];

    if (empty($nom) || empty($pass) || empty($mail) || empty($Confirme)) {
        echo "Tous les champs sont obligatoires";
        $erreursIns[] = ["Tous les champs sont obligatoires"];
    } elseif (!preg_match("/^[a-zA-Z ]+$/", $nom)) {
        echo "Donner un nom correct";
        $erreursIns[] = ["Donner un nom correct"];
    } elseif (!preg_match("/^[a-zA-Z0-9]+@[a-zA-Z]+\.[a-zA-Z]{2,5}$/", $mail)) {
        echo "Donner un email correct";
        $erreursIns[] = ["Donner un email correct"];
    } elseif (strlen($pass) !=  8) {
        echo "Le mot de passe doit contenir au moins 8 caracteres";
        $erreursIns[] = ["Le mot de passe doit contenir au moins 8 caracteres"];
    } elseif ($pass != $Confirme) {
        echo "Mot de passe et confirmation differents";
        $erreursIns[] = ["Mot de passe et confirmation differents"];
    } else {

        $sql1 = ("SELECT * FROM users WHERE email = :mail ");

        $select = $connexion->prepare($sql1);

        $select->bindParam(':mail', $mail);

        $select->execute();

        $retour = $select->fetchAll();

        if ($retour) {
            echo "Cet email est déjà utilisé";
            $erreursIns[] = ["Cet email est déjà utilisé"];
        } else {

            $cryppass = md5($_POST['passe']);

            $sql = ("INSERT INTO `users`(`nom`, `email`, `motdepasse`) VALUES (:nom ,:email , :pass)");

            $insertion = $connexion->prepare($sql);

            $insertion->bindParam(':nom', $_POST['nom']);
            $insertion->bindParam(':email', $_POST['email']);
            $insertion->bindParam(':pass', $cryppass);

            $insertion->execute();

            // var_dump($insertion->errorInfo());
            // die;

            header('Location: connexion.php');

            // echo "Incription effectuée avec succès";
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
        <h1 id="bien">Inscription</h1>

        <form action="" method="post">

            <div>

                <label for="">Nom d'utilisateur</label>
                <input class="tel" type="text" name="nom" placeholder="Entrez votre nom" value="<?php if (!empty($erreursIns)) echo $nom ?>"><br>

            </div>

            <div>
                <label for="">Adresse Email</label>
                <input class="tel" type="text" name="email" placeholder="Entrer votre email" value="<?php if (!empty($erreursIns)) echo $mail ?>"><br>
            </div>

            <div>
                <label for="">Mot de Passe</label>
                <input class="tel" type="text" name="passe" placeholder="********" value="<?php if (!empty($erreursIns)) echo $pass ?>"><br>
                <br>
            </div>

            <div>
                <label for="">Confirmation</label>
                <input class="tel" type="text" name="confirme" placeholder="********" value="<?php if (!empty($erreursIns)) echo $Confirme ?>"><br>
                <br>
            </div>

            <input id="ins2" type="submit" name="inscription" value="Créer un compte">


        </form>
        <br>

        <a href="connexion.php" id="lien">J'ai déjà un compte</a>

    </div>


</body>

</html>