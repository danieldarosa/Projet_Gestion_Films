<?php
require_once 'fonctions.php';
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
                <ul><a href="./Profil.php">Profil</a></ul>
                    <?php
                    //On verifie si la personne connectée est bien un administrateur
                    if ($_SESSION['admin'] == 1) {
                        IfAdmin();
                    }
                    ?>
                </tr>
            </nav>
            <section>
                <form id="Modifier" action="Modifier_Profil_Reussi.php" method="post" >
                    <h1>Modifier votre profil</h1>
                    <?php
                    if (isset($_SESSION['user_name'])) {
                        InfoUser();
                    }
                    ?>
                </form>
            </section>
            <footer>
            </footer>
        </div>
    </body>
</html>