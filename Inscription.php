<?php
/* ------------------------------------------------------------------------------
 * Projet : Projet gestion de films
 * Fichier : Inscription.php
 * Description : Page qui permet à un nouvel utilisateur s'inscrire au site
 * Auteur : Daniel DA ROSA
 * Version : 1.0
------------------------------------------------------------------------------ */

//On commence la session
session_start();

//On verifie si l'utilisateur est logué dans le site, si oui il est redirigé sur sa page de profil
if (!empty($_SESSION['user_id'])) {
    header('Location: ./Profil.php');
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
                <h1>Inscription :</h1>
                <form id="inscription" action="Inscription_Reussi.php" method="post" >
                    <fieldset>
                        <legend>
                            Formulaire d'inscription
                        </legend>
                        <table>
                            <tr>
                                <td>
                                    Nom :*
                                </td>
                                <td>
                                    <input type="text" name="nom" id="nom" placeholder="Nom" required autofocus />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Prénom :*
                                </td>
                                <td>
                                    <input type="text" name="prenom" id="prenom" placeholder="Prénom" required autofocus />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Pseudonyme :*
                                </td>
                                <td>
                                    <input type="text" name="pseudo" id="pseudo" placeholder="Pseudonyme" required autofocus />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Email :*
                                </td>
                                <td>
                                    <input type="email"  name="email" id="email" placeholder="email@mondomaine.com" required autofocus/>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Mot de passe :*
                                </td>
                                <td>
                                    <input type="password" name="password" id="password" placeholder="" required autofocus/>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Date de naissance :*
                                </td>
                                <td>
                                    <input type="date" name="date" id="date" placeholder="Votre âge"/>
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
                <p>Les champs avec * sont obligatoires</p>
            </section>
            <footer>
                Copyright® - Daniel DA ROSA - 2015
            </footer>
        </div>
    </body>
</html>