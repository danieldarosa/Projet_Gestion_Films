<?php
require_once 'Fonctions.php';
session_start();

if (isset($_REQUEST['envoyer'])) {
    DeleteUser($_REQUEST['id']);
    header('Location: ./Administration.php');
}
?>