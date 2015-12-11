<?php
/* ------------------------------------------------------------------------------
 * Projet : Projet gestion de films
 * Fichier : Profil.php
 * Description : Page qui affiche le profil de l'utilisateur qui est connecté
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
                if (isset($_SESSION['user_name'])) {
                    WelcomeMessage($_SESSION['user_name']);
                }
                ?>
            </header>
            <nav>
                <h1>Menu</h1>
                <ul><a href="./Profil.php">Profil</a></ul>
                <ul><a href="./Liste_Videos.php">Voir les vidéos</a></ul>
                <?php
                //On verifie si la personne connectée est bien un administrateur
                if ($_SESSION['admin'] == 1) {
                    IfAdmin();
                }
                ?>
                <ul><a href="./Support.php">Support</a></ul>
                <ul><a href="./Logout.php">Logout</a></ul>
            </nav>
            <section>
                <form id="Modifier" action="Modifier_Profil.php" method="post" >
                    <h1>Profil</h1>
                    <?php
                    if (isset($_SESSION['user_name'])) {
                        ReadUser($_SESSION['user_id']);
                    }
                    ?>
                    <input type="submit" name="modifier" value="Modifier votre profil" align="right">
                </form>
            </section>
            <footer>
                Copyright® - Daniel DA ROSA - 2015
            </footer>
        </div>
    </body>
</html>