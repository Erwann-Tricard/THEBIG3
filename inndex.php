<?php

$messageUpload = "";

if (isset($_POST['submit_photo'])) {
    $uploadDir = "uploads/";

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $photoName = basename($_FILES["photo"]["name"]);
    $targetFile = $uploadDir . $photoName;

    if (move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFile)) {
        $messageUpload = "Photo envoyée avec succès !";
    } else {
        $messageUpload = "Erreur durant l'envoi.";
    }
}


$messageVote = "";

if (isset($_POST["submit_vote"])) {
    $vote = $_POST["photo_vote"];
    file_put_contents("votes.txt", $vote . PHP_EOL, FILE_APPEND);
    $messageVote = "Votre vote a été enregistré, merci !";
}


$photos = array_diff(scandir("uploads"), array('.', '..'));
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Concours Photo</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="page-background">

<header class="header-main">
    <h1>Participer au Concours</h1>
</header>

<section class="main-container">

    <h2>Envoyer votre photo</h2>

    <form method="POST" enctype="multipart/form-data" class="form-box">
        <label>Choisir une photo :</label>
        <input type="file" name="photo" required>
        <button type="submit" name="submit_photo" class="btn-main">Envoyer</button>
    </form>

    <p><?php echo $messageUpload; ?></p>

    <hr>

    <h2>Voter pour une photo</h2>

    <form method="POST" class="form-box">
        <label>Choisissez votre photo préférée :</label>
        <select name="photo_vote" required>
            <?php foreach ($photos as $p): ?>
                <option value="<?php echo $p; ?>"><?php echo $p; ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit" name="submit_vote" class="btn-main">Voter</button>
    </form>

    <p><?php echo $messageVote; ?></p>

</section>

<footer class="footer-main">
    <p>© Concours Photo – La Motte</p>
</footer>

</body>
</html>
