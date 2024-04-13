<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Partage d'image </title>
    <link rel="stylesheet" href="partage.css">
</head>

<body>
    <div class="container">
        
        <?php
        // importt les fichiers
        require_once 'db.php';
        
        if (isset($_GET['contenu_id'])) {
            $contenu_id = $_GET['contenu_id'];
            
            $pdo = db(); 
            $stmt = $pdo->prepare("SELECT * FROM contenus WHERE id = :contenu_id");
            $stmt->bindParam(':contenu_id', $contenu_id, PDO::PARAM_INT);
            $stmt->execute();
            $contenu = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($contenu) {
                
                $imageFilename = $contenu['chemin_image'];
                $imagePath = 'images/' . $imageFilename; 
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


