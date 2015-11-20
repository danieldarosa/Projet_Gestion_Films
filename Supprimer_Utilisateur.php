<?php
require_once 'Fonctions.php';
//On commence la session
session_start();

//On verifie si l'utilisateur n'est pas logué dans le site, si oui il est redirigé sur la page d'acceuil
if ($_SESSION['admin'] != 1) {
    header('Location: ./Profil.php');
    exit();
}

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
                <form id="SuppressionUser" action="Supprimer_Utilisateur_Reussi.php" method="post">
                    <?php
                    $id = $_GET['id'];
                    echo'<input type="hidden" name="id" value="' . $id . '" />';
                    echo 'Voulez-vous supprimer cet utilisateur ?';
                    echo '<input id="confirmer" type="submit" name="confirmer" value="Confirmer"/><br/>';
                    ?>
                </form>
            </section>
            <footer>
            </footer>
        </div>
    </body>
</html>