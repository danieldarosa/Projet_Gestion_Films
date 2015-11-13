<?php
require_once 'Fonctions.php';

if (isset($_REQUEST['envoyer'])) {
    ModifUser($_REQUEST['idUser'], $_REQUEST['nom'], $_REQUEST['prenom'], $_REQUEST['pseudo'], $_REQUEST['email'], $_REQUEST['password'], $_REQUEST['date'], $_SESSION['admin']);
}
?>