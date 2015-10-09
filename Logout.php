<?php
	//On enlève et détruit toutes les sessions que l'utilisateur à utilisé pour se connecter
	session_unset();
	session_destroy();

	//On redirige l'utilisateur sur la page d'acceuil
	header('Location: ./Index.php');
	exit();
?>


