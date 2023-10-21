<?php

session_start();

require_once('db.php');

// foreach ($_SESSION['user'] as $user) {
//     echo " Bienvenue " . " " . $user['nom'] . " ";
// }

$nom = $_SESSION['user'][0]['nom'];

// echo "<h1>Bienvenue $nom </h1>";

// $_SESSION['utilisateur'] = $_SESSION['user'];

// $id_user = $_SESSION['utilisateur'][0]["id_user"];
// var_dump($_SESSION['utilisateur']);
// var_dump($id_user);
// die;

// if (isset($_POST['deconnect'])) {
//     session_unset();
//     session_destroy();
//     header('location:inscription.php');
//     exit;
// }
$id_user = $_SESSION['utilisateur'][0]["id_user"];

if (isset($_POST['ajouter'])) {

    $titre = $_POST['titre'];
    $desc = $_POST['desc'];
    $dateEcheance = $_POST['date'];
    $statut = $_POST['statut'];
    $priorite = $_POST['priorite'];
    $id_user = $_SESSION['utilisateur'][0]["id_user"];
    $erreur = [];
    $date_jour = date('Y-m-d');

    // var_dump($dateEcheance);
    // var_dump($date_jour);
    // die;



    if (empty($titre) || empty($dateEcheance) || empty($statut) || empty($priorite)) {
        echo "Tous les champs sont obligatoires <br>";
        $erreur[] = "les champs Titre et Date echeance sont obligatoires";
    } elseif (!preg_match("/^[a-zA-Z0-9 %$&'^-_.]+$/", $titre)) {
        echo "Entrer un Titre correct svp. <br>";
        $erreur[] = "Entrer un Titre correct svp.";
    } elseif (!date($dateEcheance) || $dateEcheance  < $date_jour) {
        echo "Entrez une date correct svp";
        $erreur[] = "Entrez une date correct svp";
    } else {

        $sql = ("INSERT INTO `taches` (`titre`, `description`, `priorite`, `statut`, `date_echeance`, `id_us`) VALUES (:titre, :descrip, :prio, :sta, :dateech, :user)");

        $tache = $connexion->prepare($sql);

        $tache->bindParam(':titre', $titre);
        $tache->bindParam(':descrip', $desc);
        $tache->bindParam(':dateech', $dateEcheance);
        $tache->bindParam(':prio', $priorite);
        $tache->bindParam(':sta', $statut);
        $tache->bindParam(':user', $id_user);

        $tache->execute();

        // var_dump($tache->errorInfo());
        // die;

        echo "Taches ajouter avec succes";
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

    <div class="acceuil">
        <?php echo "<h1> Bienvenue $nom </h1>" ?>
    </div>

    <div id="general">

        <div id="div1">
            <h1 id="bien">Ajouter Une Tâche</h1>

            <form action="" method="post">

                <div>

                    <label for="">Titre</label>
                    <input class="tel" type="text" name="titre" placeholder="Entrez le titre" value="<?php if (!empty($erreur)) echo $titre ?>"><br>

                </div>

                <div>
                    <label for="">Description</label>


                    <textarea name="desc" class="tel" placeholder="Donnez une description" value="<?php if (!empty($erreur)) echo $desc ?>" cols="30" rows="10"></textarea><br>
                </div>

                <div>
                    <label for="">Date échéance</label>
                    <input class="tel" type="date" name="date" placeholder="Donner la date" value="<?php if (!empty($erreur)) echo $dateEcheance ?>"><br>
                </div>

                <div>
                    <label for="priorite">Priorité</label>
                    <select class="select" name="priorite">
                        <option value="faible" <?php if (!empty($erreur) && $priorite == 'faible') echo 'selected'; ?>>Faible</option>
                        <option value="moyen" <?php if (!empty($erreur) && $priorite == 'moyen') echo 'selected'; ?>>Moyen</option>
                        <option value="eleve" <?php if (!empty($erreur) && $priorite == 'eleve') echo 'selected'; ?>>Elevé</option>
                    </select>
                </div>


                <div>
                    <label for="statut">Statut</label>
                    <select class="select" name="statut">
                        <option value="A faire" <?php if (!empty($erreur) && $statut == 'A faire') echo 'selected'; ?>>A faire</option>
                        <option value="en cours" <?php if (!empty($erreur) && $statut == 'en cours') echo 'selected'; ?>>En cours</option>
                        <option value="Terminée" <?php if (!empty($erreur) && $statut == 'Terminée') echo 'selected'; ?>>Terminée</option>
                    </select>
                </div><br><br>



                <input id="ins2" type="submit" name="ajouter" value="Ajouter">


            </form>

        </div>



        <div id="div3">

            <?php

            $req = ("SELECT * FROM `taches` WHERE id_us = :us");

            $exeReq = $connexion->prepare($req);

            $exeReq->bindParam(':us', $id_user);

            $exeReq->execute();

            $taches = $exeReq->fetchAll();

            $_SESSION['taches'] = $taches;

            ?>
            <h1 class="liste">Liste de mes tâches</h1>
            <table border="1">
                <tr>
                    <th>Titre</th>
                    <th>Description</th>
                    <th>Détails</th>
                    <th>supprimer</th>
                    <!-- Ajoutez d'autres en-têtes de colonnes si nécessaire -->
                </tr>

                <?php foreach ($taches as $tache) { ?>
                    <tr>
                        <td><?php echo $tache['titre']; ?></td>
                        <td><?php echo $tache['description']; ?></td>
                        <td>
                            <form action="detail.php" method="post">
                                <input type="hidden" name="tache_id" value="<?php echo $tache['id']; ?>">
                                <input type="submit" class="details" name="details" value="Détails">
                            </form>

                        </td>

                        <td>
                            <form action="" method="post">
                                <input type="hidden" name="sup_id" value="<?php echo $tache['id']; ?>">
                                <input type="submit" class="supprime" name="supprime" value="supprimer">
                            </form>
                        </td>
                        <!-- Ajoutez d'autres cellules si nécessaire -->
                    </tr>
                <?php } ?>
            </table>
            <?php
            // } else {
            //     echo "Aucune tâche n'a été trouvée.";
            // }


            if (isset($_POST['supprime'])) {

                $tacheSup = $_POST['sup_id'];

                $sup = "DELETE FROM `taches` WHERE id = :id_tache";

                $stmt = $connexion->prepare($sup);
                $stmt->bindParam(':id_tache', $tacheSup, PDO::PARAM_INT);
                $result = $stmt->execute();

                if ($result) {
                    echo "Tâche supprimée";
                } else {
                    echo "Une erreur s'est produite lors de la suppression de la tâche.";
                }
            }



            // if (isset($_POST['supprime'])) {
            //     $sup = ("DELETE FROM `taches` WHERE id_us = $id_user");

            //     $result = $connexion->query($sup);
            // }






            ?>

        </div>




    </div>





</body>

</html>