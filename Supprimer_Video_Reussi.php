<?php
/* ------------------------------------------------------------------------------
 * Projet : Projet gestion de films
 * Fichier : Admin.php
 * Description : Page qui supprime la vidéo choisie dans la base
 * Auteur : Daniel DA ROSA
 * Version : 1.0
------------------------------------------------------------------------------ */

session_start();
require_once 'FonctionsDB.php';

if(isset($_REQUEST['supprimer'])) {
    DeleteVideo($_SESSION['user_id'], $_SESSION['idVideo']);
}

if (isset($_REQUEST['confirmer'])) {
    DeleteVideoByAdmin($_REQUEST['id']);
}
?>