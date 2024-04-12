<?php
require_once 'db.php';
require_once 'composants/header.php';

// Récupérer l'ID de l'utilisateur à afficher depuis les paramètres de l'URL
$id_utilisateur = isset($_GET['id']) ? intval($_GET['id']) : null;

if ($id_utilisateur) {
    // Fonction pour récupérer les contenus de l'utilisateur depuis la base de données
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
                echo '<a href="partage.php">Partager</a>';
                echo '</div>'; // Fermeture de content-links
                echo '</div>'; // Fermeture de post-box
            }
            echo '</div>'; // Fermeture de la grille
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
        // Affichage des contenus de l'utilisateur
        afficherContenusUtilisateur($id_utilisateur);
        ?>
    </body>

    </html>

<?php
} else {
    echo 'Ereur';
}
?>
