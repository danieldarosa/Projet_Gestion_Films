<?php

function GetConnection() {
    DEFINE("HOST", "127.0.0.1");
    DEFINE("DBNAME", "gestion_film");
    DEFINE("USERNAME", "root");
    DEFINE("PASSWORD", "");

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

function Login() {
//On met dans des variables les données reçues par l'utilisateur
    $email = $_REQUEST['email'];
    $password = $_REQUEST['password'];
    $Hashpassword = sha1(md5(sha1($password . $email)));

//On prépare la requête
    $count = GetConnection()->prepare("SELECT * FROM users WHERE Email='$email' AND Password = '$Hashpassword'  LIMIT 1");

//On execute la requête
    $count->execute();

    $row = $count->fetch(PDO::FETCH_ASSOC);

// Si on a trouvé un utilisateur
    if ($row != null) {
        //On commmence la session
        session_start();
        $_SESSION['user_id'] = $row['idUser'];
        $_SESSION['user_name'] = $row['email'];
        $_SESSION['admin'] = $row['admin'];

        header('Location: ./Profil.php');
        exit();
    }
}

function InsertUser() {
    if (!empty($_REQUEST['nom'])) {

        $nom = $_REQUEST['nom'];
        $prenom = $_REQUEST['prenom'];
        $pseudo = $_REQUEST['pseudo'];
        $email = $_REQUEST['email'];
        $password = $_REQUEST['password'];
        $Hashpassword = sha1(md5(sha1($password . $email)));
        $date = $_REQUEST['date'];

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

function ReadUser() {
    if (isset($_SESSION['user_id'])) {
        //On prépare la requête pour afficher les informations
        $count = GetConnection()->prepare("SELECT * FROM users WHERE idUser = '" . $_SESSION['user_id'] . "' LIMIT 1");

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
    echo '<ul><a href="./Admin.php"> Administration </a></ul>';
    echo '<ul><a href="./Gestion_Utilisateurs.php"> Gestion des utilisateurs </a></ul>';
    echo '<ul><a href="./Gestion_Posts.php"> Gestion des Vidéos </a></ul>';
}

function WelcomeMessage() {
    echo 'Bienvenue ' . $_SESSION['user_name'] . '.';
    echo '<br />';
    echo '<a href="./Logout.php">Logout</a>';
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

function ModifUser() {
    if (!empty($_REQUEST['nom'])) {

        $admin = $_SESSION['admin'];
        $user = $_REQUEST['idUser'];

        $nom = $_REQUEST['nom'];
        $prenom = $_REQUEST['prenom'];
        $pseudo = $_REQUEST['pseudo'];
        $email = $_REQUEST['email'];
        $password = $_REQUEST['password'];
        $Hashpassword = sha1(md5(sha1($password . $email)));
        $date = $_REQUEST['date'];

        //On prépare la requête d'ajout des données dans la base avec les paramètres choisis
        $count = GetConnection()->prepare("UPDATE users SET nom = :nom, prenom = :prenom, pseudo = :pseudo, email = :email, password = :password, dateNaissance = :date, admin = '$admin' WHERE idUser = '$user'");

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

function AddVideos() {
    if (!empty($_REQUEST['nom'])) {

        $nom = $_REQUEST['nom'];
        $prenom = $_REQUEST['prenom'];
        $pseudo = $_REQUEST['pseudo'];
        $email = $_REQUEST['email'];
        $password = $_REQUEST['password'];
        $Hashpassword = sha1(md5(sha1($password . $email)));
        $date = $_REQUEST['date'];

        //On prépare la requête d'ajout des données dans la base avec les paramètres choisis
        $count = GetConnection()->prepare("UPDATE users SET nom = :nom, prenom = :prenom, pseudo = :pseudo, email = :email, password = :password, dateNaissance = :date, admin = '$admin' WHERE idUser = '$user'");

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

?>