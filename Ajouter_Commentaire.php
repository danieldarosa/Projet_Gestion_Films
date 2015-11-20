<?php
session_start();
require_once 'FonctionsDB.php';

if (isset($_REQUEST['commenter'])) {
    AddComment($_REQUEST['commentaire'], $_SESSION['user_id'], $_SESSION['idVideo']);
}
?>