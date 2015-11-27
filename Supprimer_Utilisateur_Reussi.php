<?php
session_start();
require_once 'FonctionsDB.php';

if (isset($_REQUEST['confirmer'])) {
    DeleteUser($_REQUEST['id']);
}
?>