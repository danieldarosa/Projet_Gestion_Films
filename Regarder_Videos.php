<?php
require_once 'FonctionsDB.php';
//On commence la session
session_start();
GetDataVideo($_GET['id']);
?>

<!DOCTYPE HTML>
<html lang="fr">
    <head> 
        <meta http-equiv="content-type" content="test/html; charset=UTF-8" />
        <title>Projet gestion films</title>
        <link href="./css/cssProjet.css" rel="stylesheet" type="text/css" media="all" charset="UTF-8"></link>
    </head>
    <body> 
        <div id="Conteneur">
            <header>
                <?php
                //On affiche un message de bienvenue à l'utilisateur qui est connecté
                if ($_SESSION['connecte'] == true) {
                    WelcomeMessage($_SESSION['user_name']);
                } else {
                    IfNotConnected();
                }
                ?>
            </header>
            <nav>
                <h1>Menu</h1>
                <?php
                if ($_SESSION['connecte'] == true) {
                    IfConnected();
                    //On verifie si la personne connectée est bien un administrateur
                    if ($_SESSION['admin'] == 1) {
                        IfAdmin();
                    }
                }
                ?>
                <?php
                if ($_SESSION['connecte'] == false) {
                    echo'<ul><a href="./Index.php">Page d\'acceuil</a></ul>';
                }
                ?>
                <ul><a href="./Liste_Videos.php">Voir les vidéos</a></ul>
                <ul><a href="./Support.php">Support</a></ul>
            </nav>
            <section>
                <form id="Supprimer" action="Supprimer_Video_Reussi.php">
                    <?php
                    if (isset($_SESSION['idVideo'])) {
                        ShowVideo($_SESSION['idVideo']);
                    }
                    ?>
                    <?php
                    if ($_SESSION['connecte'] == true) {
                        if ($_SESSION['user_id'] == $_GET['idUser']) {
                            echo'<br/><input type="submit" name="supprimer" value="Supprimer la vidéo">';
                        }
                    }
                    ?>
                </form>
                <form id="Commentaire" action="Ajouter_Commentaire.php">
                    <h1>Commentaires de la vidéo</h1>
                    <?php
                    ShowComments($_SESSION['idVideo']);
                    if ($_SESSION['connecte'] == true) {

                        echo '<textarea name="commentaire" cols="133" rows="3" placeholder="Ajouter un commentaire" required autofocus></textarea>';
                        echo'<br />';
                        echo'<input type="submit" name="commenter" value="Ajouter un commentaire">';
                    }
                    ?>

                </form>
            </section>
            <footer>
                Copyright® - Daniel DA ROSA - 2015
            </footer>
        </div>
    </body>
</html>