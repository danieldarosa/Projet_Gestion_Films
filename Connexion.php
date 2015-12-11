<?php
/* ------------------------------------------------------------------------------
 * Projet : Projet gestion de films
 * Fichier : Connexion.php
 * Description : Page qui permet de se connecter au site
 * Auteur : Daniel DA ROSA
 * Version : 1.0
------------------------------------------------------------------------------ */
require_once 'FonctionsDB.php';

if (isset($_REQUEST['envoyer'])) {
    Login($_REQUEST['email'], $_REQUEST['password']);
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
                <form id="connexion" action="Connexion.php" method="post" >
                    Connexion :
                    <input type="text" name="email" id="email" placeholder="Email" required autofocus />
                    <input type="password" name="password" id="password" placeholder="Mot de passe" required />
                    <input type="submit" name="envoyer" id="envoyer" required  />
                </form>
            </header>
            <nav>
                <h1>Menu</h1>
                <ul><a href="./Index.php">Page d'acceuil</a></ul>
                <ul><a href="./Support.php">Support</a></ul>
            </nav>
            <section>
                <h1>Tentative de connexion echouée</h1>
                <p>Vous n'avez pas rentré les bons champs... veuillez réessayer</p>
            </section>
            <footer>
                Copyright® - Daniel DA ROSA - 2015
            </footer>
        </div>
    </body>
</html>