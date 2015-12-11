<?php
/* ------------------------------------------------------------------------------
 * Projet : Projet gestion de films
 * Fichier : Fonctions_Affichage.php
 * Description : Page qui regroupe les fonctions d'affichage des données
 * Auteur : Daniel DA ROSA
 * Version : 1.0
------------------------------------------------------------------------------ */

require_once 'FonctionsDB.php';

//Fonction qui affiche les données de l'utilisateur
function ReadUser($id) {
    if (isset($id)) {
        //On prépare la requête pour afficher les informations de l'utilisateur puis on l'éxecute
        $count = GetConnection()->prepare("SELECT * FROM users WHERE idUser = '" . $id . "' LIMIT 1");
        $count->execute();

        //On met dans un tableau les données reçus de la base
        $ligne = $count->fetch(PDO::FETCH_ASSOC);

        //On affiche les informations de l'utilisateur reçus de la base de données
        echo ' Nom : ' . $ligne['nom'] . ' <br/> ';
        echo ' Prénom : ' . $ligne['prenom'] . ' <br/> ';
        echo ' Pseudonyme : ' . $ligne['pseudo'] . ' <br/> ';
        echo ' Email : ' . $ligne['email'] . ' <br/> ';
        echo ' Date de naissance : ' . $ligne['dateNaissance'] . ' <br/> ';
    }
}


//Fonction qui affiche le message de bienvenue à l'utilisateur
function WelcomeMessage($user) {
    echo 'Bienvenue ' . $user;
}

//Fonction qui permet de modifier les données de l'utilisateur
function InfoUser() {
    //On prépare la requête de séléction des données de l'utilisateur qui est connecté puis on l'éxecute
    $count = GetConnection()->prepare("SELECT * FROM users WHERE idUser = '" . $_SESSION['user_id'] . "' LIMIT 1");
    $count->execute();
    
    //On met les valeurs dans un tableau
    $ligne = $count->fetch(PDO::FETCH_ASSOC);

    //On affiche les données de l'utilisateur
    echo '<fieldset>
        <legend>
	Modifier votre profil
	</legend>
        <input type="hidden" name="idUser" value="' . $ligne['idUser'] . '" />
	<table>
            <tr>
		<td>
                    Nouveau nom :
		</td>
		<td>
                    <input type="text" name="nom" id="nom" value="' . $ligne['nom'] . '"" required autofocus />
		</td>
            </tr>
            <tr>
		<td>
                    Nouveau prénom :
		</td>
		<td>
                    <input type="text" name="prenom" id="prenom" value="' . $ligne['prenom'] . '" required />
		</td>
            </tr>
            <tr>
		<td>
                    Nouveau pseudonyme :
		</td>
		<td>
                    <input type="text" name="pseudo" id="pseudo" value="' . $ligne['pseudo'] . '" required />
		</td>
            </tr>
            <tr>
		<td>
                    Nouvel email :
		</td>
		<td>
                    <input type="email"  name="email" id="email"  value="' . $ligne['email'] . '" required />
		</td>
            </tr>
            <tr>
		<td>
                    Nouveau mot de passe :
		</td>
		<td>
                    <input type="password"  name="password" id="password" required autofocus/>
		</td>
            </tr>
            <tr>
		<td>
                    Nouvelle date de naissance :
		</td>
		<td>
                    <input type="date" name="date" id="date" value="' . $ligne['dateNaissance'] . '" required />
		</td>
            </tr>
            <tr>
		<td>
		</td>
		<td>						
                    <input type="submit" name="envoyer" id="button" value="Modifier"   />
		</td>
            </tr>
        </table>
    </fieldset>';
}


//Fonction qui affiche la vidéo que l'on a choisi
function ShowVideo($idVideo) {
    //On prépare la requête pour afficher les informations de la vidéo qu'on a choisi puis on l'éxecute
    $showVideo = GetConnection()->prepare("SELECT * FROM videos NATURAL JOIN users NATURAL JOIN categories WHERE idVideo = '$idVideo' ORDER BY nomVideo ASC ");
    $showVideo->execute();

    //On met les valeurs dans un tableau
    while ($row = $showVideo->fetch(PDO::FETCH_ASSOC)) {
        //On affiche les informations de la vidéo à chaque tour de boucle
        echo '<h1>' . $row['nomVideo'] . '</h1>';
        echo '<br />';
        echo '<iframe width="950" height="500" src="https://www.youtube.com/embed/' . $row['lienVideo'] . '" frameborder="0" allowfullscreen></iframe>';
        echo '<br />';
        echo 'Date d\' ajout : ' . $row['dateAjout'];
        echo '<br />';
        echo 'Ajouté par  ' . $row['pseudo'];
        echo '<br />';
        echo '<br />';
        echo 'Description : ' . $row['descVideo'];
    }
}

//Fonction qui permet d'afficher tous les utilsateurs présents dans le site
function GetAllUsers() {
    //On met dans une variable le résultat de la fonction sélectionnée
    $user = SelectAllUsers();
    
    foreach ($user as $value) {
        //On affiche tous les commentaires avec toutes les informations
        echo ' Nom : ' . $value['nom'] . ' <br/> ';
        echo ' Prénom : ' . $value['prenom'] . ' <br/> ';
        echo ' Pseudo : ' . $value['pseudo'] . ' <br/> ';
        echo ' Email : ' . $value['email'] . ' <br/> ';
        echo ' Date de naisssance : ' . $value['dateNaissance'] . ' <br/> ';
        //On affiche le lien seulement si l'utilisateur n'est pas admin
        if ($_SESSION['admin'] != $value['admin']) {
            echo '<a href="Supprimer_Utilisateur.php?id=' . $value['idUser'] . '">Supprimer l\'utilisateur</a> <br/>';
        }
        echo '<br/>';
    }
}

//Fonction qui permet d'afficher toutes les vidéos présentes dans le site
function GetAllVideos() {
    //On met dans une variable le résultat de la fonction sélectionnée
    $video = SelectAllVideos();
    
    foreach ($video as $value) {
        //On affiche tous les commentaires avec toutes les informations
        echo ' Nom de la vidéo : ' . $value['nomVideo'] . ' <br/> ';
        echo ' Par : ' . $value['pseudo'] . ' <br/> ';
        echo ' Catégorie : ' . $value['nomCategorie'] . ' <br/> ';
        echo '<a href="Supprimer_Video.php?id=' . $value['idVideo'] . '">Supprimer la vidéo</a> <br/>';
        echo '<br/>';
    }
}

//Fonction qui permet d'afficher tous les commentaires de la vidéo qu'on a choisi
function ShowComments($idVideo) {
    //On sélectionne tous les commentaires qui sont présentes dans la vidéo qu'on a choisi
    $select = GetConnection()->prepare("SELECT * FROM commentaires NATURAL JOIN users WHERE idVideo = '$idVideo' ORDER BY idCommentaire ASC");
    $select->execute();
    
    //On met dans un tableau les valeurs de la requête
    $comment = $select->fetchAll(PDO::FETCH_ASSOC);
    
    foreach($comment as $value) {
        //On affiche tous les commentaires avec toutes les informations
        echo ''. $value['pseudo'] .' le, '. $value['dateMessage'] .': <br/>';
        echo ''. $value['message'] .'<br/>';
        echo '<br/>';
    }
}

//Fonction de vérification si l'utilisateur est un administrateur
function IfAdmin() {
    echo '<ul><a href="./Administration.php"> Administration </a></ul>';
}

//Fonction qui affiche les liens si l'utilisateur n'est pas connecté
function IfNotConnected() {
    echo '<form id="connexion" action="Connexion.php" method="post" >
          Connexion :
          <input type="text" name="email" id="email" placeholder="Email" required autofocus />
          <input type="password" name="password" id="password" placeholder="Mot de passe" required />
          <input type="submit" name="envoyer" id="envoyer" required  />
          </form>';
}

//Fonction qui affiche les liens si l'utilisateur est connecté
function IfConnected() {
    echo '<ul><a href="./Profil.php">Profil</a></ul>
          <ul><a href="./Logout.php">Logout</a></ul>';
}
?>