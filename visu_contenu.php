<?php
require_once 'db.php';


// Récupération des données du contenu (remplacez 'votre_contenu_id' par l'ID du contenu)
$contenu_id = $_GET['contenu_id']; // Supposons que vous passiez l'ID du contenu via l'URL
$sql = "SELECT * FROM contenu WHERE id = $contenu_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nom_utilisateur = $row['nom_utilisateur'];
    $image_url = $row['image_url'];
    $likes = $row['likes'];

    // Récupération des commentaires associés à ce contenu
    $sql_comments = "SELECT * FROM commentaires WHERE contenu_id = $contenu_id";
    $result_comments = $conn->query($sql_comments);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualisation du contenu</title>
</head>
<body>
    <h1>Contenu</h1>
    <p>Nom d'utilisateur : <a href="visu_utilisateur.php?utilisateur=<?php echo $nom_utilisateur; ?>"><?php echo $nom_utilisateur; ?></a></p>
    <p>Image : <a href="visu_contenu.php?contenu=<?php echo $contenu_id; ?>"><img src="<?php echo $image_url; ?>" alt="Image du contenu"></a></p>
    <p>Likes : <?php echo $likes; ?></p>

    <h2>Commentaires</h2>
    <ul>
        <?php
        if ($result_comments->num_rows > 0) {
            while ($row_comment = $result_comments->fetch_assoc()) {
                $commentaire = $row_comment['commentaire'];
                echo "<li>$commentaire</li>";
            }
        } else {
            echo "<li>Aucun commentaire .</li>";
        }
        ?>
    </ul>

    <form action="traitement_commentaire.php" method="post">
        <label for="nouveau_commentaire">Ajouter un commentaire :</label>
        <input type="text" id="nouveau_commentaire" name="nouveau_commentaire">
        <input type="hidden" name="contenu_id" value="<?php echo $contenu_id; ?>">
        <input type="submit" value="Ajouter">
    </form>
</body>
</html>

<?php
// Fermeture de la connexion à la base de données
$conn->close();
?>
