<?php
/* ------------------------------------------------------------------------------
 * Projet : Projet gestion de films
 * Fichier : Supprimer_Utilisateur_Reussi.php
 * Description : Page qui supprime l'utilisateur choisi dans la base de données
 * Auteur : Daniel DA ROSA
 * Version : 1.0
------------------------------------------------------------------------------ */

session_start();
require_once 'FonctionsDB.php';

if (isset($_REQUEST['confirmer'])) {
    DeleteUser($_REQUEST['id']);
}
?>