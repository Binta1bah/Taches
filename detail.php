<?php
session_start();

require_once('db.php');

$afficheId = $_SESSION['taches'][0]['id'];
$afficheTitre = $_SESSION['taches'][0]['titre'];
$afficheDescript = $_SESSION['taches'][0]['description'];
$afficheDate = $_SESSION['taches'][0]['date_echeance'];
$affichePrio = $_SESSION['taches'][0]['priorite'];
$afficheStatut = $_SESSION['taches'][0]['statut'];

if (isset($_POST['modifier'])) {
    $idT = $_POST['modifStatut'];
    $newStatut = $_POST['statut'];
    // var_dump($newStatut);
    // die;

    if (empty($newStatut)) {
        echo "Selectioner le nouveau statut";
    } else {
        $requette = ("UPDATE taches SET statut = :statut WHERE id = :id");
        $prepar = $connexion->prepare($requette);
        $prepar->bindParam(':statut', $newStatut);
        $prepar->bindParam(':id', $idT);


        $modif = $prepar->execute();

        if ($modif) {
            echo "Modification effectuée";
        } else {
            echo "Modification non effectuée";
        }

        $afficheStatut = $newStatut;
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
    <div class="afficheDetails">
        <div>
            <?php echo "<h1> Titre: $afficheTitre </h2>" ?>
        </div>

        <div>
            <?php echo "<h2> Description: $afficheDescript </h2>" ?>
        </div>

        <div>
            <?php echo "<h3> Date d'écheance: $afficheDate </h2>" ?>
        </div>

        <div>
            <?php echo "<h3> Priorité: $affichePrio </h2>" ?>
        </div>

        <div>
            <?php echo "<h3> Statut: $afficheStatut </h2>" ?>

        </div>

        <div class="styleModif">

            <form action="" method="post">

                <select class="sel" name="statut">
                    <option value="" selected disabled>Modifier le statut</option>
                    <option value="A faire">A faire</option>
                    <option value="en cours">En cours</option>
                    <option value="Terminée">Terminée</option>
                </select>


                <input type="hidden" name="modifStatut" value="<?php echo $afficheId ?>">
                <input type="submit" id="modif" name="modifier" value="Modifier">


            </form>

        </div>

        <?php




        ?>



    </div>


    ?>
</body>

</html>