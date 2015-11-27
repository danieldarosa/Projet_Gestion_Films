<?php
require_once 'Fonctions_Affichage.php';

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

function IfAdmin() {
    echo '<ul><a href="./Administration.php"> Administration </a></ul>';
}

function WelcomeMessage($user) {
    echo 'Bienvenue ' . $user;
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

function SelectAllUsers() {
    $select = GetConnection()->prepare("SELECT * FROM users");
    $select->execute();
    $user = $select->fetchAll(PDO::FETCH_ASSOC);
    return $user;
}

function SelectAllVideos() {
    $select = GetConnection()->prepare("SELECT * FROM videos NATURAL JOIN users NATURAL JOIN categories");
    $select->execute();
    $video = $select->fetchAll(PDO::FETCH_ASSOC);
    return $video;
}

function DeleteUser($id) {
    $deleteUser = GetConnection()->prepare("DELETE FROM users WHERE idUser = '$id'");
    $deleteUser->execute();
    $deleteVideosUser = GetConnection()->prepare("DELETE FROM videos WHERE idUser = '$id'");
    $deleteVideosUser->execute();
    $deleteCommentsUser = GetConnection()->prepare("DELETE FROM commentaires WHERE idUser = '$id'");
    $deleteCommentsUser->execute();
    header('Location: ./Administration.php');
}

function DeleteVideo($idUser, $idVideo) {
    $delete = GetConnection()->prepare("DELETE FROM videos WHERE idVideo = '$idVideo' AND idUser = '$idUser'");
    $delete->execute();
    $deleteCommentsVideo = GetConnection()->prepare("DELETE FROM commentaires WHERE idVideo = '$id' AND idUser = '$idUser'");
    $deleteCommentsVideo->execute();
    header('Location: ./Liste_Videos.php');
}

function DeleteVideoByAdmin($id) {
    $deleteVideosUser = GetConnection()->prepare("DELETE FROM videos WHERE idVideo = '$id'");
    $deleteVideosUser->execute();
    $deleteCommentsUser = GetConnection()->prepare("DELETE FROM commentaires WHERE idVideo = '$id'");
    $deleteCommentsUser->execute();
    header('Location: ./Liste_Videos.php');
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

?>