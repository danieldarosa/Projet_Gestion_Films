<?php
session_start();
require_once 'Fonctions.php';

if (isset($_REQUEST['confirmer'])) {
    DeleteVideo($_REQUEST['id']);
}
?>