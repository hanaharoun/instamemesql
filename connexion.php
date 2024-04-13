<?php
// Inclusion du fichier de connexion à la base de données
require_once 'db.php';



// Vérification si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Verification
    if (isset($_POST["pseudo"]) && isset($_POST["mot_de_passe"])) {

        // Recupere
        $pseudo = $_POST["pseudo"];
        $mot_de_passe = $_POST["mot_de_passe"];

        // pour remplir tt les champs 
         
        if (empty($pseudo) || empty($mot_de_passe)) {
            $error = "Veuillez remplir tous les champs.";
        } else {
            // verific des inf dans la bdd
            $pdo = db();
            $query = "SELECT * FROM utilisateurs WHERE pseudo = ?";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$pseudo]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                
                //  mot de passe
                if (md5($mot_de_passe) == $user['mot_de_passe']) {
                    
                    session_start();
                    $_SESSION['user_id'] = $user['id_utilisateur'];
                    $_SESSION['pseudo'] = $user['pseudo'];
                    
                    header("Location: welcome.php");
                    exit();
                } else {
                    $error = "Mot de passe incorrect.";
                }
            } else {
                $error = "Utilisateur non trouvé. Veuillez vérifier vos informations de connexion.";
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="connexion.css">
</head>
<body>
    <div id="wrapper">
        <div class="main-content">
            <div class="header">InstaMeme</div>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="l-part">
                <input type="text" name="pseudo" placeholder="Nom d'utilisateur" class="input-1" required />
                <div class="overlap-text">
                    <input type="password" name="mot_de_passe" placeholder="Mot de passe" class="input-2" required />
                </div>
                <input type="submit" value="Se connecter" class="btn" />
            </form>
            

           
        </div>
        <div class="sub-content">
            <div class="s-part">
                Pas de compte ? <a href="inscription.php">Inscrivez-vous</a>
            </div>
        </div>
    </div>
</body>
</html>
