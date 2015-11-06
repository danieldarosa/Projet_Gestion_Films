<?php
require_once 'Fonctions.php';

if (isset($_REQUEST['envoyer'])) {
    InsertUser($_REQUEST['nom'], $_REQUEST['prenom'], $_REQUEST['pseudo'], $_REQUEST['email'], $_REQUEST['password'], $_REQUEST['date']);
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
            <header>A faire à la maison (image)</header>
            <nav>
                <form id="connexion" action="Connexion.php" method="post" >
                    <fieldset class="log">
                        <legend>
                            Connexion
                        </legend>
                        <table>
                            <tr>
                                <td>
                                    <input type="text" name="email" id="email" placeholder="Email" required autofocus />
                                </td>
                            </tr>
                            <tr>
                                <tr>
                                    <td>
                                        <input type="password" name="password" id="password" placeholder="Mot de passe" required autofocus />
                                    </td>
                                </tr>
                                <tr>
                                    <tr>
                                        <td>
                                            <input type="submit" name="envoyer" id="envoyer" placeholder="Mot de passe" required autofocus />
                                        </td>
                                    </tr>
                                </tr>
                            </tr>
                        </table>
                    </fieldset>
                </form>
            </nav>
            <section>
                <p>Génial ! Vous faites parti désormais de ce site !</p>
                <p>Maintenant vous pouvez jeter un coup d'oeil a votre profil et aux autres fonctionnalités du site en vous connectant.</p>
            </section>
            <footer>A faire à la maison (Image)</footer>
        </div>
    </body>
</html>