<?php
require_once('db.php');

if (isset($_POST['valider'])) {
    $mail = $_POST['email'];
    $pass = $_POST['passe'];
    $confirm = $_POST['conPasse'];
    $er = [];

    if (empty($mail) || empty($pass) || empty($confirm)) {
        echo "Tous les champs sont obligtoires";
        $er[] = ["Tous les champs sont obligtoires"];
    } elseif ($pass != $confirm) {
        echo "Confirmez bien le mot de passe";
        $er[] = ["Confirmez bien le mot de passe"];
    } else {

        $crypt = md5($pass);
        $req = ("UPDATE users SET motdepasse = :pass WHERE email = :mail");
        $exReq = $connexion->prepare($req);
        $exReq->bindParam(':pass', $crypt);
        $exReq->bindParam(':mail', $mail);

        $passModif = $exReq->execute();

        if ($passModif) {
            header('location:connexion.php');
        } else {
            echo "Mofification non effectuée";
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
        <h1 id="bien">Nouveau mot de passe</h1>

        <form action="" method="post">


            <div>
                <label for="">Adresse Email</label>
                <input class="tel" type="text" name="email" placeholder="Entrer votre email" value="<?php if (!empty($er)) echo $mail ?>"><br>
            </div>

            <div>
                <label for="">Nouveau Mot de Passe</label>
                <input class="tel" type="text" name="passe" placeholder="********" value="<?php if (!empty($er)) echo $pass ?>"><br>

            </div>

            <div>
                <label for="">Confirmer Mot de Passe</label>
                <input class="tel" type="text" name="conPasse" placeholder="********" value="<?php if (!empty($er)) echo $confirm ?>"><br>
            </div>

            <br>
            <input id="ins2" type="submit" name="valider" value="Valider">


        </form>

    </div><br>






    </div>


</body>

</html>