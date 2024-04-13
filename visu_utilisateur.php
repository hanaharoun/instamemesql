<?php
require_once 'db.php';
require_once 'composants/header.php';

// Récupérer l'ID de l'utilisateur 
$id_utilisateur = isset($_GET['id']) ? intval($_GET['id']) : null;

if ($id_utilisateur) {
    // Fonction pour récupérer les contenus de l'utilisateur 
    function getContenusUtilisateur($id_utilisateur) {
        $pdo = db();
        $stmt = $pdo->prepare("SELECT * FROM contenus WHERE id_utilisateur = :id_utilisateur");
        $stmt->bindParam(':id_utilisateur', $id_utilisateur, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fonction pour afficher les contenus de l'utilisateur

    function afficherContenusUtilisateur($id_utilisateur) {
        $contenus = getContenusUtilisateur($id_utilisateur);
        if ($contenus) {
            echo '<div class="grid grid-cols-4 gap-8">';
            foreach ($contenus as $contenu) {
                echo '<div class="post-box">';
                echo '<img src="images/' . $contenu['chemin_image'] . '" class="content-image" />';
                echo '<div class="content-links">';
                echo '<a href="#">Aimer</a>';
                echo '<a href="partage.php?contenu_id=' . $contenu['id'] . '"><button type="button">Partager</button></a>';
                echo '</div>'; 
                echo '</div>'; 
            }
            echo '</div>'; 
        } else {
            echo 'Aucun contenu trouvé pour cet utilisateur.';
        }
    }

    ?>

    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Visualisation de l'utilisateur</title>
        <link rel="stylesheet" href="visu_utilisateur.css">
    </head>

    <body>
        <?php
        
        afficherContenusUtilisateur($id_utilisateur);
        ?>
    </body>

    </html>

<?php
} else {
    echo 'Ereur';
}
?>
