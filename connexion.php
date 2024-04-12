<?php
// Inclusion du fichier de connexion à la base de données
require_once 'db.php';

// Initialisation de la variable d'erreur
$error = "";

// Vérification si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérification si les champs pseudo et mot de passe sont définis
    if (isset($_POST["pseudo"]) && isset($_POST["mot_de_passe"])) {
        // Récupération des valeurs des champs du formulaire
        $pseudo = $_POST["pseudo"];
        $mot_de_passe = $_POST["mot_de_passe"];

        // Validation des entrées (vous pouvez ajouter plus de validation au besoin)
        if (empty($pseudo) || empty($mot_de_passe)) {
            $error = "Veuillez remplir tous les champs.";
        } else {
            // Vérification des informations de connexion dans la base de données
            $pdo = db();
            $query = "SELECT * FROM utilisateurs WHERE pseudo = ?";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$pseudo]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                // Vérification du mot de passe
                if (md5($mot_de_passe) == $user['mot_de_passe']) {
                    // Mot de passe correct, connecter l'utilisateur (par exemple, définir une session)
                    session_start();
                    $_SESSION['user_id'] = $user['id_utilisateur'];
                    $_SESSION['pseudo'] = $user['pseudo'];
                    
                    // Rediriger vers une page sécurisée ou afficher un message de succès
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
            <?php 
            // Affichage du message d'erreur s'il y en a un
            if ($error) {
                echo "<p>$error</p>";
            }
            ?>
        </div>
        <div class="sub-content">
            <div class="s-part">
                Pas encore de compte ? <a href="inscription.php">Inscrivez-vous</a>
            </div>
        </div>
    </div>
</body>
</html>
