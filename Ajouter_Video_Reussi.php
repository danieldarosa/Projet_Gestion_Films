<?php
/* ------------------------------------------------------------------------------
 * Projet : Projet gestion de films
 * Fichier : Ajouter_Video_Reussi.php
 * Description : Page qui permet d'insérer les données de la vidéo dans la base
 * Auteur : Daniel DA ROSA
 * Version : 1.0
------------------------------------------------------------------------------ */
session_start();
require_once 'FonctionsDB.php';

if (isset($_REQUEST['envoyer'])) {
    AddVideos($_SESSION['user_id'], $_REQUEST['nom'], $_REQUEST['lien'], $_REQUEST['categorie'], $_REQUEST['description']);
}
?>