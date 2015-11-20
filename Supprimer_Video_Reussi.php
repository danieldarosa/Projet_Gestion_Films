<?php
session_start();
require_once 'FonctionsDB.php';

if (isset($_REQUEST['confirmer'])) {
    DeleteVideo($_REQUEST['id']);
}
?>