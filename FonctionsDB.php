<?php

require_once 'Fonctions_Affichage.php';

//Constantes pour la connexion à la base
DEFINE("HOST", "127.0.0.1");
DEFINE("DBNAME", "gestion_film");
DEFINE("USERNAME", "root");
DEFINE("PASSWORD", "");

//Fonction de connexion à la base de données
function GetConnection() {
    //On met la variable de connexion en statique
    static $dbh = null;

    try {
        //On insère les constantes pour les données de connexion
        if ($dbh == null) {
            $dbh = new PDO('mysql:host=' . HOST . ';dbname=' . DBNAME, USERNAME, PASSWORD);
        }
    } catch (PDOException $e) {
        //On affiche un message d'erreur si la connexion s'est mal passée
        die('Erreur : ' . $e->getMessage());
    }
    //On retourne la variable de connexion
    return $dbh;
}

//Fonction de connexion au site
function Login($email, $password) {
    //On hash le mot de passe que l'on à inséré dans le champ
    $Hashpassword = sha1(md5(sha1($password . $email)));

    //On prépare la requête de sélection des données de l'utilisateur qui veut se connecter et on compare les champs rentrés par l'utilisateur et les champs de la base puis on éxecute la requête
    $count = GetConnection()->prepare("SELECT * FROM users WHERE Email='$email' AND Password = '$Hashpassword'  LIMIT 1");
    $count->execute();

    //On met les valeurs dans un tableau
    $row = $count->fetch(PDO::FETCH_ASSOC);

    //Si les données correspondent, on crée les variables de session de l'utilisateur
    if ($row != null) {
        session_start();
        $_SESSION['user_id'] = $row['idUser'];
        $_SESSION['user_name'] = $row['email'];
        $_SESSION['admin'] = $row['admin'];
        $_SESSION['connecte'] = true;

        //On redirige l'utilisateur dans sa page de profil
        header('Location: ./Profil.php');
        exit();
    }
}

function logout() {
    //On enlève et détruit toutes les sessions que l'utilisateur à utilisé pour se connecter
    session_start();
    session_unset();
    session_destroy();

    $_SESSION['connecte'] = false;
    //On redirige l'utilisateur sur la page d'acceuil
    header('Location: ./Index.php');
    exit();
}

//Fonction d'insertion de l'utilisateur
function InsertUser($nom, $prenom, $pseudo, $email, $password, $date) {
    if (!empty($nom)) {
        //On hash le mot de passe que l'on à inséré dans le champ
        $Hashpassword = sha1(md5(sha1($password . $email)));

        //On prépare la requête d'ajout des données dans la base avec les paramètres choisis puis on l'éxecute
        $count = GetConnection()->prepare("INSERT INTO users(nom,prenom,pseudo,email,password,dateNaissance,admin) VALUES(:nom, :prenom, :pseudo, :email, :password, :date, 0)");

        //On met en paramètre ce qu'on veut ajouter dans la base
        $count->bindParam(':nom', $nom, PDO::PARAM_STR);
        $count->bindParam(':prenom', $prenom, PDO::PARAM_STR);
        $count->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
        $count->bindParam(':email', $email, PDO::PARAM_STR);
        $count->bindParam(':password', $Hashpassword, PDO::PARAM_STR);
        $count->bindParam(':date', $date, PDO::PARAM_INT);

        $count->execute();
    } else {
        //Si non, on affiche un message d'erreur
        echo 'Les champs remplis ne sont pas corrects...';
    }
}

//Fonction qui permet de modifier le profil de l'utilisateur
function ModifUser($id, $nom, $prenom, $pseudo, $email, $password, $date, $admin) {
    if (!empty($nom)) {
        //On hash le mot de passe que l'on à inséré dans le champ
        $Hashpassword = sha1(md5(sha1($password . $email)));

        //On prépare la requête de modification des données dans la base avec les paramètres choisis puis on l'éxecute
        $count = GetConnection()->prepare("UPDATE users SET nom = :nom, prenom = :prenom, pseudo = :pseudo, email = :email, password = :password, dateNaissance = :date, admin = '$admin' WHERE idUser = '$id'");

        //On met en paramètre ce qu'on veut modifier dans la base
        $count->bindParam(':nom', $nom, PDO::PARAM_STR);
        $count->bindParam(':prenom', $prenom, PDO::PARAM_STR);
        $count->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
        $count->bindParam(':email', $email, PDO::PARAM_STR);
        $count->bindParam(':password', $Hashpassword, PDO::PARAM_STR);
        $count->bindParam(':date', $date, PDO::PARAM_INT);

        $count->execute();

        //L'utilisateur est redirigé sur la page de profil
        header('Location: ./Profil.php');
    } else {
        //Si non, on affiche un message d'erreur
        echo 'Les champs remplis ne sont pas corrects...';
    }
}

//Fonction qui séléctionne les catégories qui sont présentes dans la base
function SelectCategories() {
    //On encode les champs des catégories en utf8
    $count = GetConnection()->exec('SET NAMES utf8');

    //On prépare la requête de séléction des catégories présentes dans la base puis on éxecute celle-ci
    $count = GetConnection()->prepare("SELECT * FROM categories ");
    $count->execute();

    while ($row = $count->fetch(PDO::FETCH_ASSOC)) {
        //On affiche les valeurs à chaque tour de boucle
        echo '<option value="' . $row['idCategorie'] . '">' . $row['nomCategorie'] . '</option>';
    }
}

//Fonction qui permet d'ajouter la vidéo dans la base
function AddVideos($id, $nom, $lien, $categorie, $description) {
    if (!empty($nom)) {
        //On prépare la requête d'ajout des données dans la base avec les paramètres choisis puis on l'éxecute
        $count = GetConnection()->prepare("INSERT INTO videos(nomVideo,lienVideo,descVideo,dateAjout,idCategorie,idUser) VALUES(:nom, :lien, :description, CURRENT_TIMESTAMP, '$categorie', '$id')");

        //On met en paramètre ce qu'on veut ajouter dans la base
        $count->bindParam(':nom', $nom, PDO::PARAM_STR);
        $count->bindParam(':lien', $lien, PDO::PARAM_STR);
        $count->bindParam(':description', $description, PDO::PARAM_STR);

        $count->execute();

        //L'utilisateur est redirigé sur la page de la liste des vidéos
        header('Location: ./Liste_Videos.php');
    } else {
        //Si non, on affiche un message d'erreur
        echo 'Les champs remplis ne sont pas corrects...';
    }
}

//Fonction qui séléctionne toutes les vidéos présentes dans la base
function SelectVideos() {
    
    //On prépare la requête de sélection de toutes les vidéos présentes dans la base puis on l'éxecute
    $count = GetConnection()->prepare("SELECT * FROM videos NATURAL JOIN users ORDER BY nomVideo");
    $count->execute();

    //On affiche toutes les vidéos qui existent dans la base
    while ($row = $count->fetch(PDO::FETCH_ASSOC)) {
        //On affiche les vidéos à chaque tour de boucle
        echo '<br />';
        echo '<a href="Regarder_Videos.php?id=' . $row['idVideo'] . '&idUser=' . $row['idUser'] . '">' . $row['nomVideo'] . '</a> - par: ' . $row['pseudo'];
        echo '<br />';
    }
}

//Fonction qui récupère les données de la vidéo qu'on veut regarder
function GetDataVideo($id) {
    //On prépare la requête pour sélectioner toutes les données de la vidéo puis on l'éxecute
    $selectVideo = GetConnection()->prepare("SELECT * FROM videos WHERE idVideo = $id ");
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

//Fonction qui séléctionne tout les utilisateurs présentes dans le site
function SelectAllUsers() {
    //On encode les noms en utf8
    $select = GetConnection()->exec('SET NAMES utf8');
    //On prépare la requête de séléction des utilisateurs
    $select = GetConnection()->prepare("SELECT * FROM users");
    $select->execute();

    //On met les données de la requête dans un tableau
    $user = $select->fetchAll(PDO::FETCH_ASSOC);

    //On retourne les valeurs du tableau
    return $user;
}

//Fonction qui séléctionne toutes les vidéos qui sont présentes dans le site
function SelectAllVideos() {
    //On encode les catégories en utf8
    $select = GetConnection()->exec('SET NAMES utf8');
    //On prépare la requête de sélection de toutes les vidéos
    $select = GetConnection()->prepare("SELECT * FROM videos NATURAL JOIN users NATURAL JOIN categories");
    $select->execute();

    //On met les données de la requête dans un tableau
    $video = $select->fetchAll(PDO::FETCH_ASSOC);

    //On retourne les valeurs du tableau
    return $video;
}

//Fonction qui permet de supprimer l'utilisateur ainsi que ses vidéos et commentaires qu'il à ajouté
function DeleteUser($id) {
    //On prépare la requête de suppression de l'utilisateur puis on l'éxecute
    $deleteUser = GetConnection()->prepare("DELETE FROM users WHERE idUser = '$id'");
    $deleteUser->execute();

    //On prépare la requête de suppression des vidéos de l'utilisateur qu'on va supprimer puis on l'éxecute
    $deleteVideosUser = GetConnection()->prepare("DELETE FROM videos WHERE idUser = '$id'");
    $deleteVideosUser->execute();

    //On prépare la requête de suppression des commentaires de l'utilisateur que l'on va supprimer puis on l'éxecute
    $deleteCommentsUser = GetConnection()->prepare("DELETE FROM commentaires WHERE idUser = '$id'");
    $deleteCommentsUser->execute();

    //On redirige l'administrateurm dans la page d'administration
    header('Location: ./Administration.php');
}

//Fonction qui permet de supprimer la vidéo que l'utilisateur à ajouté uniquement ainsi que tous les commentaires qui sont présents
function DeleteVideo($idUser, $idVideo) {
    //On prépare la requête de suppression de la vidéo de l'utilisateur qui l'a ajouté puis on l'éxecute
    $delete = GetConnection()->prepare("DELETE FROM videos WHERE idVideo = '$idVideo' AND idUser = '$idUser'");
    $delete->execute();

    //On prépare la requête de suppression des commentaires de la vidéo puis on l'éxecute
    $deleteCommentsVideo = GetConnection()->prepare("DELETE FROM commentaires WHERE idVideo = '$idVideo' AND idUser = '$idUser'");
    $deleteCommentsVideo->execute();

    //On redirige l'utilisateur dans la page des vidéos présentes
    header('Location: ./Liste_Videos.php');
}

//Fonction qui permet de supprimer la vidéo séléctionnée dans la page administrateur et qui supprime les commentaires
function DeleteVideoByAdmin($id) {
    //On prépare la requête de suppression de la vidéo que l'administrateur veut supprimer puis on l'éxecute
    $deleteVideosUser = GetConnection()->prepare("DELETE FROM videos WHERE idVideo = '$id'");
    $deleteVideosUser->execute();

    //On prépare la requête de suppression des commentaires de la vidéos qu'on va supprimer puis on l'éxecute
    $deleteCommentsUser = GetConnection()->prepare("DELETE FROM commentaires WHERE idVideo = '$id'");
    $deleteCommentsUser->execute();

    //On redirige l'administrateur dans la page d'administration
    header('Location: ./Administration.php');
}

//Fonction qui permet d'ajouter un commentaire
function AddComment($comment, $idUser, $idVideo) {
    if (!empty($comment)) {
        //On prépare la requête d'ajout des données dans la base avec les paramètres choisis et on éxecute la requête
        $count = GetConnection()->prepare("INSERT INTO commentaires(message,dateMessage,idVideo,idUser) VALUES(:comment, CURRENT_TIMESTAMP, '$idVideo', '$idUser')");

        //On met en paramètre ce qu'on veut ajouter dans la base
        $count->bindParam(':comment', $comment, PDO::PARAM_STR);
        $count->execute();
    }
    //On redirige l'utilisateur sur la page ou il a commenté la vidéo
    header('Location: ./Regarder_Videos.php?id=' . $idVideo . '&idUser=' . $idUser . '');
}

?>