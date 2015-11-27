<?php
require_once 'FonctionsDB.php';
if(!empty($_SESSION['user_id'])) {
//On commence la session
session_start();
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
                else {
                    IfNotConnected();
                }
                ?>
            </header>
            <nav>
                <h1>Menu</h1>
                
                <?php
                if(!empty($_SESSION['user_id'])) {
                    IfConnected();
                    //On verifie si la personne connectée est bien un administrateur
                    if ($_SESSION['admin'] == 1) {
                        IfAdmin();
                    }
                }
                ?>
                <?php
                    if(empty($_SESSION['user_id'])) {
                        echo'<ul><a href="./Index.php">Page d\'acceuil</a></ul>';
                    }
                ?>
                <ul><a href="./Support.php">Support</a></ul>
                
            </nav>
            <section>
                <h1>Liste des vidéos</h1>
                <?php
                    if(!empty($_SESSION['user_id'])) {
                        echo'<a href="./Ajouter_Video.php">Ajouter une vidéo</a>';
                    }
                ?>
                <br />
                <?php SelectVideos(); ?>
            </section>
            <footer>
            </footer>
        </div>
    </body>
</html>