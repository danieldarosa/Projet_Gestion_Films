<?php
/* ------------------------------------------------------------------------------
 * Projet : Projet gestion de films
 * Fichier : Tutoriel_Ajout_Video.php
 * Description : Page qui permet à l'utilisateur de savoir comment ajouter une vidéo sur le site
 * Auteur : Daniel DA ROSA
 * Version : 1.0
------------------------------------------------------------------------------ */

require_once 'FonctionsDB.php';
//On commence la session
session_start();

//On verifie si l'utilisateur n'est pas logué dans le site, si oui il est redirigé sur la page d'acceuil
if (empty($_SESSION['user_name'])) {
    header('Location: ./Index.php');
    exit();
}
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
                if (isset($_SESSION['user_name'])) {
                    WelcomeMessage($_SESSION['user_name']);
                }
                ?>
            </header>
            <nav>
                <h1>Menu</h1>
                <ul><a href="./Profil.php">Profil</a></ul>
                <ul><a href="./Liste_Videos.php">Voir les vidéos</a></ul>
                <ul><a href="./Support.php">Support</a></ul>
                <ul><a href="./Logout.php">Logout</a></ul>
                <?php
                //On verifie si la personne connectée est bien un administrateur
                if ($_SESSION['admin'] == 1) {
                    IfAdmin();
                }
                ?>
            </nav>
            <section>
                <h1>Comment ajouter une vidéo</h1>
                <p>Dans ce site, vous pouvez ajouter vos vidéos qui sont sur votre compte Youtube sur ce site.</p>
                <p>Pour cela, il faut seulement récupérer la chaîne de caracatère qui se trouve à la fin de votre lien après le "v=" comme sur cette image ci-dessous :</p>
                <img src="Images/lien.PNG" alt="lien" />
                <p>Après avoir copié ce lien (Ctrl + C), il vous suffit désormais de le coller (Ctrl + V) dans le champ "lien de la vidéo".</p>
                <p>Pour finir il vous faut remplir les autres champs et cliquer sur le bouton de confirmation, et votre vidéo et ajoutée !</p>
                <a href="./Ajouter_Video.php">Retourner sur la page d'ajout de la vidéo</a>
            </section>
            <footer>
                Copyright® - Daniel DA ROSA - 2015
            </footer>
        </div>
    </body>
</html>