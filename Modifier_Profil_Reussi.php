<?php
/* ------------------------------------------------------------------------------
 * Projet : Projet gestion de films
 * Fichier : Modifier_Profil_Reussi.php
 * Description : Page qui modifie les données de l'utilsateur dans la base
 * Auteur : Daniel DA ROSA
 * Version : 1.0
------------------------------------------------------------------------------ */

require_once 'FonctionsDB.php';

if (isset($_REQUEST['envoyer'])) {
    ModifUser($_REQUEST['idUser'], $_REQUEST['nom'], $_REQUEST['prenom'], $_REQUEST['pseudo'], $_REQUEST['email'], $_REQUEST['password'], $_REQUEST['date'], $_SESSION['admin']);
}
?>