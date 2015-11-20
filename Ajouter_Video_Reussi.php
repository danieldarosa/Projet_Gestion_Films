<?php
session_start();
require_once 'FonctionsDB.php';

if (isset($_REQUEST['envoyer'])) {
    AddVideos($_SESSION['user_id'], $_REQUEST['nom'], $_REQUEST['lien'], $_REQUEST['categorie'], $_REQUEST['description']);
}
?>