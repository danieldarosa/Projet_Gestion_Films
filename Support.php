<?php
/* ------------------------------------------------------------------------------
 * Projet : Projet gestion de films
 * Fichier : Support.php
 * Description : Page qui permet à n'importe quel utilisateur de contacter le support
 * Auteur : Daniel DA ROSA
 * Version : 1.0
  ------------------------------------------------------------------------------ */

require_once 'FonctionsDB.php';
//On commence la session
session_start();
?>

<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
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
                <h1>Support</h1>
                <p>Si vous avez des questions, ou le moindre soucis concernant son fonctionnement, veuillez contacter le modérateur sur cette adresse ci-dessous :</p>
                <p>film.support@gmail.com</p>
            </section>
            <footer>
                Copyright® - Daniel DA ROSA - 2015
            </footer>
        </div>
    </body>
</html>