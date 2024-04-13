<?php
// mportt des fich
require_once 'affichage.php';
require_once 'db.php';



// condition pour recher
if (isset($_GET['pseudo'])) {
    $pseudo = $_GET['pseudo'];

    // Requête pour récupérer l'ID de l'utilisateur en fonction du pseudo
    $pdo = db();
    $stmt = $pdo->prepare("SELECT id FROM utilisateurs WHERE pseudo = :pseudo");
    $stmt->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result && isset($result['id'])) {
        
        header("Location: visu_utilisateur.php?id=" . $result['id']);
        exit();
    } else {
        echo 'Utilisateur non trouvé.';
    }
}

//Fonction pour le pseudo  

function pseudoExiste($pseudo) {
    $pdo = db();
    $stmt = $pdo->prepare("SELECT COUNT(*) AS count FROM utilisateurs WHERE pseudo = :pseudo");
    $stmt->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result['count'] > 0; // Retourne vrai si le pseudo existe, sinon faux
}



// Fonction pour récupérer les contenus depuis la base de données avec les pseudonymes des utilisateurs
function getContenus($page = 1, $items_per_page = 6) {
    $pdo = db();
    $offset = ($page - 1) * $items_per_page;

    $stmt = $pdo->prepare("SELECT c.*, u.pseudo AS pseudo_utilisateur FROM contenus c INNER JOIN utilisateurs u ON c.id_utilisateur = u.id LIMIT $offset, $items_per_page");
    $stmt->execute();
    return $stmt->fetchAll();
}

// Fonction pour obtenir le nombre de likes pour un contenu donné
function getLikesCount($contenu_id) {
    $pdo = db();
    $stmt = $pdo->prepare("SELECT COUNT(*) AS total_likes FROM likes WHERE id_contenu = :contenu_id");
    $stmt->bindParam(':contenu_id', $contenu_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['total_likes'];
}

// Fonction pour obtenir le nombre total de contenus
function getTotalContenus() {
    $pdo = db();
    $stmt = $pdo->query("SELECT COUNT(*) AS total FROM contenus");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['total'];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'accueil</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>

<?php
echo pageHeader("Bonjour");
?>

<div class="grid">
    <?php
    // les contenus avec les pseudo des utilisateurs
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $contenus = getContenus($page);

    
    foreach ($contenus as $contenu) {
        echo '<div class="post-box">';
        echo '<p><a href="visu_utilisateur.php?id=' . $contenu['id_utilisateur'] . '">@' . $contenu['pseudo_utilisateur'] . '</a></p>';
        echo '<div class="flex flex-col justify-center items-center space-y-2">';
        echo '<a href="' . $contenu['id'] . '"><img src="images/' . $contenu['chemin_image'] . '" class="h-40" /></a>';
        echo '<p>Description : ' . $contenu['description'] . '</p>';

        // Afficher le nombre de likes
        echo '<p>Likes : ' . getLikesCount($contenu['id']) . '</p>';

        // Bouton Like
        echo '<a href="index.php?action=like&contenu_id=' . $contenu['id'] . '"><button type="button">Like</button></a>';

        // Bouton Partager
        echo '<a href="partage.php?contenu_id=' . $contenu['id'] . '"><button type="button">Partager</button></a>';
        
        // Formulaire de commentaire
        echo '<form action="index.php" method="post">';
        echo '<input type="hidden" name="contenu_id" value="' . $contenu['id'] . '">';
        echo '<input type="text" name="commentaire" placeholder="commenter">';
        echo '<button type="submit" name="submit">Envoyer</button>';
        echo '</form>';
        echo '</div>'; 
        echo '</div>'; 
    }
    ?>
    </div>

<?php
// pagination
$total_contenus = getTotalContenus();
$items_per_page = 6;
$total_pages = ceil($total_contenus / $items_per_page);

echo '<div class="pagination">';
for ($i = 1; $i <= $total_pages; $i++) {
    echo '<a href="index.php?page=' . $i . '">' . $i . '</a>';
}
echo '</div>';

echo pageFooter();
?>

</body>
</html>

