<?php
// import des fich
require_once 'db.php';


// init de la variable d'erreur
$error = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (isset($_POST["pseudo"]) && isset($_POST["mot_de_passe"])) {
        
        $pseudo = $_POST["pseudo"];
        $mot_de_passe = $_POST["mot_de_passe"];

        
        if (empty($pseudo) || empty($mot_de_passe)) {
            $error = "Veuillez remplir tous les champs.";
        } else {
            // Vérification si le pseudo existe déjà 
            $pdo = db();
            $query = "SELECT * FROM utilisateurs WHERE pseudo = ?";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$pseudo]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                $error = "Ce pseudo est déjà pris. Veuillez choisir un autre.";
            } else {
                
                $hashed_password = md5($mot_de_passe);

               
                $query = "INSERT INTO utilisateurs (pseudo, mot_de_passe) VALUES (?, ?)";
                $stmt = $pdo->prepare($query);
                $stmt->execute([$pseudo, $hashed_password]);

                if ($stmt) {
                   
                    header("Location: connexion.php");
                    exit();
                } else {
                    $error = "Une erreur s'est produite lors de l'inscription. Veuillez réessayer.";
                }
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
    <title>Inscription</title>
    <link rel="stylesheet" href="inscription.css">
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
                <input type="submit" value="S'inscrire" class="btn" />
            </form>
            <?php 
            
            if ($error) {
                echo "<p>$error</p>";
            }
            ?>
        </div>
        <div class="sub-content">
            <div class="s-part">
                Déjà un compte ? <a href="connexion.php">Connectez-vous</a>
            </div>
        </div>
    </div>
</body>
</html>
