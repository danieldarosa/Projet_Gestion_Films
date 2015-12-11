<?php
/* ------------------------------------------------------------------------------
 * Projet : Projet gestion de films
 * Fichier : Liste_Videos.php
 * Description : Page qui affiche toutes les vidéos présentes sur le site
 * Auteur : Daniel DA ROSA
 * Version : 1.0
------------------------------------------------------------------------------ */

require_once 'FonctionsDB.php';

session_start();
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
                }
                else {
                    IfNotConnected();
                }
                ?>
            </header>
            <nav>
                <h1>Menu</h1>                
                <?php
                if($_SESSION['connecte'] == true) {
                    IfConnected();
                    //On verifie si la personne connectée est bien un administrateur
                    if ($_SESSION['admin'] == 1) {
                        IfAdmin();
                    }
                }
                ?>
                <?php
                    if($_SESSION['connecte'] == false) {
                        echo'<ul><a href="./Index.php">Page d\'acceuil</a></ul>';
                    }
                ?>
                <ul><a href="./Liste_Videos.php">Voir les vidéos</a></ul>
                <ul><a href="./Support.php">Support</a></ul>
                
            </nav>
            <section>
                <h1>Liste des vidéos</h1>
                <?php
                    if($_SESSION['connecte'] == true) {
                        echo'<a href="./Ajouter_Video.php">Ajouter une vidéo</a>';
                    }
                ?>
                <br />
                <?php SelectVideos(); ?>
            </section>
            <footer>
                Copyright® - Daniel DA ROSA - 2015
            </footer>
        </div>
    </body>
</html>