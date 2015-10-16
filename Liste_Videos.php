<?php
require_once 'Fonctions.php';
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
            </header>
            <nav>
                <fieldset class="log">
                    <legend>
                        Logout
                    </legend>
                    <?php
                    //On affiche un message de bienvenue à l'utilisateur qui est connecté
                    if (isset($_SESSION['user_name'])) {
                        WelcomeMessage();
                    }
                    ?>
                </fieldset>
                <h1>Menu</h1>
                <ul><a href="./Profil.php">Profil</a></ul>
                <ul><a href="./Liste_Videos.php">Voir les vidéos</a></ul>
                <?php
                //On verifie si la personne connectée est bien un administrateur
                if ($_SESSION['admin'] == 1) {
                    IfAdmin();
                }
                ?>
            </nav>
            <section>
                    <h1>Liste des vidéos</h1>
                    <a href="./Ajouter_Video.php">Ajouter une vidéo</a>
            </section>
            <footer>
            </footer>
        </div>
    </body>
</html>