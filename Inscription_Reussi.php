<?php
require_once 'FonctionsDB.php';

if (isset($_REQUEST['envoyer'])) {
    InsertUser($_REQUEST['nom'], $_REQUEST['prenom'], $_REQUEST['pseudo'], $_REQUEST['email'], $_REQUEST['password'], $_REQUEST['date']);
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
                <h1>Incription réussi !</h1>
                <p>Génial ! Vous faites parti désormais de ce site !</p>
                <p>Maintenant vous pouvez jeter un coup d'oeil a votre profil et aux autres fonctionnalités du site en vous connectant.</p>
            </section>
            <footer></footer>
        </div>
    </body>
</html>