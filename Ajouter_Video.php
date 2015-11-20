<?php
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
                <form id="video" action="./Ajouter_Video_Reussi.php" method="post" >
                    <h1>Ajouter une vidéo</h1>
                    <a href="./Tutoriel_Ajout_Video.php">Comment ajouter une vidéo Youtube</a>
                    <fieldset>
                        <legend>
                            Ajout d'une vidéo
                        </legend>
                        <table>
                            <tr>
                                <td>
                                    Nom de la vidéo :
                                </td>
                                <td>
                                    <input type="text" name="nom" id="nom" placeholder="Nom" required autofocus />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Lien de votre vidéo :*
                                </td>
                                <td>
                                    <input type="text" name="lien" id="lien" placeholder="Lien de la vidéo" required autofocus />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Catégorie :
                                </td>
                                <td>
                                    <select name="categorie" size="1"><?php SelectCategories(); ?></select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Descritpion :
                                </td>
                                <td>
                                    <textarea name="description" cols="50" rows="10"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                </td>
                                <td>						
                                    <input type="submit" id="button" name="envoyer" value="Envoyez"   />
                                </td>
                            </tr>
                        </table>
                    </fieldset>
                </form>
                <p>*Voir tutoriel pour le lien de votre vidéo</p>
            </section>
            <footer>
            </footer>
        </div>
    </body>
</html>