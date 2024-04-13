<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Partage d'image </title>
    <!-- Lien vers votre fichier CSS -->
    <link rel="stylesheet" href="partage.css">
</head>

<body>
    <div class="container">
        
        <?php
        // Inclusion des fichiers nécessaires (connexion à la base de données, fonctions, etc.)
        require_once 'db.php';
        // Vérification de la présence de 'contenu_id' dans l'URL
        if (isset($_GET['contenu_id'])) {
            $contenu_id = $_GET['contenu_id'];
            // Récupération des informations sur le contenu depuis la base de données
            $pdo = db(); // Fonction pour établir une connexion PDO à la base de données
            $stmt = $pdo->prepare("SELECT * FROM contenus WHERE id = :contenu_id");
            $stmt->bindParam(':contenu_id', $contenu_id, PDO::PARAM_INT);
            $stmt->execute();
            $contenu = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($contenu) {
                // Construction du chemin complet vers l'image
                $imageFilename = $contenu['chemin_image'];
                $imagePath = 'images/' . $imageFilename; // Chemin relatif vers le répertoire images
                // Affichage de l'image et de la description du contenu
                echo '<h1>Partage d\'image</h1>';
                echo '<div class="image-container">';
                echo '<img src="' . $imagePath . '" alt="Image à partager">';
                echo '</div>';
                echo '<p>Description : ' . htmlspecialchars($contenu['description']) . '</p>';
            } else {
                echo '<p>Contenu non trouvé.</p>';
            }
        } else {
            echo '<p>Paramètre \'contenu_id\' non fourni.</p>';
        }
        ?>
    </div>
</body>

</html>


