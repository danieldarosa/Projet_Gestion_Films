<?php
//On commence la session
session_start();

//On verifie si l'utilisateur est logué dans le site, si oui il est redirigé sur sa page de profil
if (!empty($_SESSION['user_id'])) {
    header('Location: ./Profil.php');
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
            <header>A faire à la maison (image)</header>
            <nav></nav>
            <section>
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
            <footer>A faire à la maison (image)</footer>
        </div>
    </body>
</html>