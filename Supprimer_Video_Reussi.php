<?php
session_start();
require_once 'FonctionsDB.php';

if(isset($_REQUEST['supprimer'])) {
    DeleteVideo($_SESSION['user_id'], $_SESSION['idVideo']);
}

if (isset($_REQUEST['confirmer'])) {
    DeleteVideoByAdmin($_REQUEST['id']);
}
?>