<?php
/* ------------------------------------------------------------------------------
 * Projet : Projet gestion de films
 * Fichier : Index.php
 * Description : Page d'acceuil du site
 * Auteur : Daniel DA ROSA
 * Version : 1.0
------------------------------------------------------------------------------ */
session_start();
$_SESSION['connecte'] = false;
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
                <form id="connexion" action="Connexion.php" method="post" >
                    Connexion :
                    <input type="text" name="email" id="email" placeholder="Email" required autofocus />
                    <input type="password" name="password" id="password" placeholder="Mot de passe" required />
                    <input type="submit" name="envoyer" id="envoyer" required  />
                </form>
            </header>
            <nav>
                <h1>Menu</h1>
                <ul><a href="./Support.php">Support</a></ul>
                <ul><a href="./Liste_Videos.php">Voir les vidéos</a></ul>
            </nav>
            <section>
                <h1>Bienvenue !</h1>
                <p>Si vous voulez vous inscrire cliquez sur le lien d'inscription en-dessous.</p>
                <a href="Inscription.php">Inscrivez-vous !</a>
            </section>
            <footer>
                Copyright® - Daniel DA ROSA - 2015
            </footer>
        </div>
    </body>
</html>