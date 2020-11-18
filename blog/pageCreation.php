<?php
//PAGE FORMULAIRE DU BLOG

session_start();

//verifie si est bien connecté
if ($_SESSION['login'] == 'no') {
  header("Location:form.php");
}

//verifie les erreurs possibles recupere
if (isset($_GET["publie"]) && $_GET["publie"]=="false") {
  echo "<b>formulaire incorrect</b>";
}else if (isset($_GET["publie"]) && $_GET["publie"]=="ImageToBig") {
  echo "<b>le fichier choisi est trop grand</b>";
}else if(isset($_GET["publie"]) && $_GET["publie"]=="true"){
  echo "<b>article publié !!</b>";
}
?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <p>Bonjour <?php echo $_SESSION['id_name'];  ?> !</p>
    </br></br>
    <!-- Formulaire de creation de l'article -->
    <form action="CreationBlog.php" method="post" enctype="multipart/form-data">
      <label for="titre"><b>Titre :</b></label></br>
      <input type="text" name="titre"></br>
      <label for="commentaire"><b>commentaire :</b></label></br>
      <textarea name="commentaire" rows="8" cols="80"></textarea></br>
      <label for="image"><b>Image :</b></label></br>
      <input type="file" name="image" value="img"></br></br>
      <input type="submit" name="ok" value="Envoyer">
    </form>
    <a href="index.php">page d'accueil</a>
  </body>
</html>
