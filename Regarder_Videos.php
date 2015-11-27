<?php
require_once 'FonctionsDB.php';
//On commence la session
session_start();
GetDataVideo($_GET['id'], $_GET['idUser']);
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
                <form id="Supprimer" action="Supprimer_Video_Reussi.php">
                    <?php
                    if (isset($_SESSION['idVideo'])) {
                        ShowVideo($_SESSION['idVideo']);
                    }
                    ?>
                    <?php
                    if($_SESSION['user_id'] == $_GET['idUser']) {
                        echo'<br/><input type="submit" name="supprimer" value="Supprimer la vidéo">';
                    }
                    ?>
                </form>
                <form id="Commentaire" action="Ajouter_Commentaire.php">
                    <h1>Commentaires de la vidéo</h1>
                    <?php
                    ShowComments($_SESSION['idVideo']);
                    ?>
                    <textarea name="commentaire" cols="133" rows="3" placeholder="Ajouter un commentaire" required autofocus></textarea>
                    <br />
                    <input type="submit" name="commenter" value="Ajouter un commentaire">
                </form>
            </section>
            <footer>
            </footer>
        </div>
    </body>
</html>