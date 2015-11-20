<?php

DEFINE("HOST", "127.0.0.1");
DEFINE("DBNAME", "gestion_film");
DEFINE("USERNAME", "root");
DEFINE("PASSWORD", "");

function GetConnection() {
    static $dbh = null;

    try {
        if ($dbh == null) {
            $dbh = new PDO('mysql:host=' . HOST . ';dbname=' . DBNAME, USERNAME, PASSWORD);
        }
    } catch (PDOException $e) {
        die('Erreur : ' . $e->getMessage());
    }
    return $dbh;
}

function Login($email, $password) {

    $Hashpassword = sha1(md5(sha1($password . $email)));

    $count = GetConnection()->prepare("SELECT * FROM users WHERE Email='$email' AND Password = '$Hashpassword'  LIMIT 1");

    $count->execute();

    $row = $count->fetch(PDO::FETCH_ASSOC);

    if ($row != null) {
        session_start();
        $_SESSION['user_id'] = $row['idUser'];
        $_SESSION['user_name'] = $row['email'];
        $_SESSION['admin'] = $row['admin'];

        header('Location: ./Profil.php');
        exit();
    }
}

function InsertUser($nom, $prenom, $pseudo, $email, $password, $date) {
    if (!empty($nom)) {

        $Hashpassword = sha1(md5(sha1($password . $email)));

        //On prépare la requête d'ajout des données dans la base avec les paramètres choisis
        $count = GetConnection()->prepare("INSERT INTO users(nom,prenom,pseudo,email,password,dateNaissance,admin) VALUES(:nom, :prenom, :pseudo, :email, :password, :date, 0)");

        //On met en paramètre ce qu'on veut ajouter dans la base
        $count->bindParam(':nom', $nom, PDO::PARAM_STR);
        $count->bindParam(':prenom', $prenom, PDO::PARAM_STR);
        $count->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
        $count->bindParam(':email', $email, PDO::PARAM_STR);
        $count->bindParam(':password', $Hashpassword, PDO::PARAM_STR);
        $count->bindParam(':date', $date, PDO::PARAM_INT);

        //On execute la requête
        $count->execute();
    } else {
        //Si non, on affiche un message d'erreur
        echo 'Les champs remplis ne sont pas corrects...';
    }
}

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

function IfAdmin() {
    echo '<ul><a href="./Administration.php"> Administration </a></ul>';
}

function WelcomeMessage($user) {
    echo 'Bienvenue ' . $user;
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

function ModifUser($id, $nom, $prenom, $pseudo, $email, $password, $date, $admin) {
    if (!empty($nom)) {
        $Hashpassword = sha1(md5(sha1($password . $email)));

        //On prépare la requête d'ajout des données dans la base avec les paramètres choisis
        $count = GetConnection()->prepare("UPDATE users SET nom = :nom, prenom = :prenom, pseudo = :pseudo, email = :email, password = :password, dateNaissance = :date, admin = '$admin' WHERE idUser = '$id'");

        //On met en paramètre ce qu'on veut ajouter dans la base
        $count->bindParam(':nom', $nom, PDO::PARAM_STR);
        $count->bindParam(':prenom', $prenom, PDO::PARAM_STR);
        $count->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
        $count->bindParam(':email', $email, PDO::PARAM_STR);
        $count->bindParam(':password', $Hashpassword, PDO::PARAM_STR);
        $count->bindParam(':date', $date, PDO::PARAM_INT);

        //On execute la requête
        $count->execute();

        //L'utilisateur est redirigé sur la page de profil
        header('Location: ./Profil.php');
    } else {
        //Si non, on affiche un message d'erreur
        echo 'Les champs remplis ne sont pas corrects...';
    }
}

function SelectCategories() {
    $count = GetConnection()->exec('SET NAMES utf8');
    $count = GetConnection()->prepare("SELECT * FROM categories ");
    $count->execute();

    while ($row = $count->fetch(PDO::FETCH_ASSOC)) {
        //On affiche les valeurs Ã  chque tour de boucle
        echo '<option value="' . $row['idCategorie'] . '">' . $row['nomCategorie'] . '</option>';
    }
}

function AddVideos($id, $nom, $lien, $categorie, $description) {
    if (!empty($nom)) {
        //On prépare la requête d'ajout des données dans la base avec les paramètres choisis
        $count = GetConnection()->prepare("INSERT INTO videos(nomVideo,lienVideo,descVideo,dateAjout,idCategorie,idUser) VALUES(:nom, :lien, :description, CURRENT_TIMESTAMP, '$categorie', '$id')");

        //On met en paramètre ce qu'on veut ajouter dans la base
        $count->bindParam(':nom', $nom, PDO::PARAM_STR);
        $count->bindParam(':lien', $lien, PDO::PARAM_STR);
        $count->bindParam(':description', $description, PDO::PARAM_STR);
        //On execute la requête
        $count->execute();

        //L'utilisateur est redirigé sur la page de la liste des vidéos
        header('Location: ./Liste_Videos.php');
    } else {
        //Si non, on affiche un message d'erreur
        echo 'Les champs remplis ne sont pas corrects...';
    }
}

function SelectVideos() {
    $count = GetConnection()->prepare("SELECT * FROM videos NATURAL JOIN users ORDER BY nomVideo");

    //On execute la requête
    $count->execute();

    //On affiche toutes les vidéos qui existent dans la base
    while ($row = $count->fetch(PDO::FETCH_ASSOC)) {
        echo '<br />';
        echo '<a href="Regarder_Videos.php?id=' . $row['idVideo'] . '&idUser=' . $row['idUser'] . '">' . $row['nomVideo'] . '</a> - par: ' . $row['pseudo'];
        echo '<br />';
    }
}

function GetDataVideo($id, $user) {
    //On prépare la requête pour sélectioner les données voulues
    $selectVideo = GetConnection()->prepare("SELECT * FROM videos WHERE idVideo = $id ");

    //On execute la requête
    $selectVideo->execute();

    //On met dans un tableau les données reçus de la base
    $row = $selectVideo->fetch(PDO::FETCH_ASSOC);

    //On vérifie si on a trouvé la bonne vidéo
    if ($row != null) {
        //On met dans des variables $_SESSION les données qui permettront de différencier la bonne vidéo
        $_SESSION['idVideo'] = $row['idVideo'];
        $_SESSION['idUser'] = $row['idUser'];
    }
}

function ShowVideo($idVideo, $idUser) {
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

function SelectAllUsers() {
    $select = GetConnection()->exec("SET NAMES utf8");
    $select = GetConnection()->prepare("SELECT * FROM users");
    $select->execute();
    $user = $select->fetchAll(PDO::FETCH_ASSOC);
    return $user;
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

function SelectAllVideos() {
    $select = GetConnection()->exec("SET NAMES utf8");
    $select = GetConnection()->prepare("SELECT * FROM videos NATURAL JOIN users NATURAL JOIN categories");
    $select->execute();
    $video = $select->fetchAll(PDO::FETCH_ASSOC);
    return $video;
}

function GetAllVideos() {
    $video = SelectAllVideos();
    foreach ($video as $value) {
        echo ' Nom de la vidéo : ' . $value['nomVideo'] . ' <br/> ';
        echo ' Par : ' . $value['pseudo'] . ' <br/> ';
        echo ' Pseudo : ' . $value['nomCategorie'] . ' <br/> ';
        echo '<a href="Supprimer_Video.php?id=' . $value['idVideo'] . '">Supprimer la vidéo</a> <br/>';
        echo '<br/>';
    }
}

function DeleteUser($id) {
    $deleteUser = GetConnection()->prepare("DELETE FROM users WHERE idUser = '$id'");
    $deleteUser->execute();
    $deleteVideosUser = GetConnection()->prepare("DELETE FROM videos WHERE idUser = '$id'");
    $deleteVideosUser->execute();
    header('Location: ./Administration.php');
}

function DeleteVideo($id) {
    $deleteVideosUser = GetConnection()->prepare("DELETE FROM videos WHERE idVideo = '$id'");
    $deleteVideosUser->execute();
    header('Location: ./Administration.php');
}

function AddComment($comment, $idUser, $idVideo) {
    if (!empty($comment)) {
        //On prépare la requête d'ajout des données dans la base avec les paramètres choisis
        $count = GetConnection()->prepare("INSERT INTO commentaires(message,dateMessage,idVideo,idUser) VALUES(:comment, CURRENT_TIMESTAMP, '$idVideo', '$idUser')");

        //On met en paramètre ce qu'on veut ajouter dans la base
        $count->bindParam(':comment', $comment, PDO::PARAM_STR);

        $count->execute();
    }
    header('Location: ./Regarder_Videos.php?id=' . $idVideo . '&idUser=' . $idUser . '');
}

function ShowComments($idVideo, $idUser) {
    $select = GetConnection()->exec("SET NAMES utf8");
    $select = GetConnection()->prepare("SELECT * FROM commentaires NATURAL JOIN users WHERE idVideo = '$idVideo' AND idUser = '$idUser'");
    $select->execute();
    $comment = $select->fetchAll(PDO::FETCH_ASSOC);
    
    foreach($comment as $value) {
        echo ''. $value['pseudo'] .' le, '. $value['dateMessage'] .': <br/>';
        echo ''. $value['message'] .'<br/>';
        echo '<br/>';
    }
}
?>