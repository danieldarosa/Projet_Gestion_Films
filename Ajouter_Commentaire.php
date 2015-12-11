<?php
/* ------------------------------------------------------------------------------
 * Projet : Projet gestion de films
 * Fichier : Ajouter_Commentaire.php
 * Description : Page qui permet d'ajouter un commentaire
 * Auteur : Daniel DA ROSA
 * Version : 1.0
------------------------------------------------------------------------------ */
session_start();
require_once 'FonctionsDB.php';

if (isset($_REQUEST['commenter'])) {
    AddComment($_REQUEST['commentaire'], $_SESSION['user_id'], $_SESSION['idVideo']);
}
?>