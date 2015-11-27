<?php
require_once 'FonctionsDB.php';

function ReadUser($id) {
    if (isset($id)) {
        //On prépare la requête pour afficher les informations
        $count = GetConnection()->prepare("SELECT * FROM users WHERE idUser = '" . $id . "' LIMIT 1");

        //On execute la requête
        $count->execute();

        //On met dans un tableau les données reçus de la base
        $ligne = $count->fetch(PDO::FETCH_ASSOC);

        //On affiche les informations reçus de la base de données
        echo ' Nom : ' . $ligne['nom'] . ' <br/> ';
        echo ' Prénom : ' . $ligne['prenom'] . ' <br/> ';
        echo ' Pseudonyme : ' . $ligne['pseudo'] . ' <br/> ';
        echo ' Email : ' . $ligne['email'] . ' <br/> ';
        echo ' Date de naissance : ' . $ligne['dateNaissance'] . ' <br/> ';
    }
}

function InfoUser() {
    $count = GetConnection()->prepare("SELECT * FROM users WHERE idUser = '" . $_SESSION['user_id'] . "' LIMIT 1");

    $count->execute();

    $ligne = $count->fetch(PDO::FETCH_ASSOC);

    //On affiche les données
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

function ShowVideo($idVideo) {
    //On prépare la requête pour afficher les informations
    $showVideo = GetConnection()->prepare("SELECT * FROM videos NATURAL JOIN users NATURAL JOIN categories WHERE idVideo = $idVideo ");

    //On execute la requête
    $showVideo->execute();

    //On crée une boucle pour afficher tout le contenu présent dans la base
    while ($row = $showVideo->fetch(PDO::FETCH_ASSOC)) {

        //On affiche les informations voulues
        echo '<h1>' . $row['nomVideo'] . '</h1>';
        echo '<br />';
        echo '<iframe width="750" height="400" src="https://www.youtube.com/embed/' . $row['lienVideo'] . '" frameborder="0" allowfullscreen></iframe>';
        echo '<br />';
        echo 'Date d\' ajout : ' . $row['dateAjout'];
        echo '<br />';
        echo 'Ajouté par  ' . $row['pseudo'];
        echo '<br />';
        echo '<br />';
        echo 'Description : ' . $row['descVideo'];
    }
}

function GetAllUsers() {
    $user = SelectAllUsers();
    foreach ($user as $value) {
        echo ' Nom : ' . $value['nom'] . ' <br/> ';
        echo ' Prénom : ' . $value['prenom'] . ' <br/> ';
        echo ' Pseudo : ' . $value['pseudo'] . ' <br/> ';
        echo ' Email : ' . $value['email'] . ' <br/> ';
        echo ' Date de naisssance : ' . $value['dateNaissance'] . ' <br/> ';
        if ($_SESSION['admin'] != $value['admin']) {
            echo '<a href="Supprimer_Utilisateur.php?id=' . $value['idUser'] . '">Supprimer l\'utilisateur</a> <br/>';
        }
        echo '<br/>';
    }
}

function GetAllVideos() {
    $video = SelectAllVideos();
    foreach ($video as $value) {
        echo ' Nom de la vidéo : ' . $value['nomVideo'] . ' <br/> ';
        echo ' Par : ' . $value['pseudo'] . ' <br/> ';
        echo ' Catégorie : ' . $value['nomCategorie'] . ' <br/> ';
        echo '<a href="Supprimer_Video.php?id=' . $value['idVideo'] . '">Supprimer la vidéo</a> <br/>';
        echo '<br/>';
    }
}

function ShowComments($idVideo) {
    $select = GetConnection()->prepare("SELECT * FROM commentaires NATURAL JOIN users WHERE idVideo = '$idVideo'");
    $select->execute();
    $comment = $select->fetchAll(PDO::FETCH_ASSOC);
    
    foreach($comment as $value) {
        echo ''. $value['pseudo'] .' le, '. $value['dateMessage'] .': <br/>';
        echo ''. $value['message'] .'<br/>';
        echo '<br/>';
    }
}
?>