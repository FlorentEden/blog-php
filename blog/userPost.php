<?php
  session_start();
if (isset($_POST["id"]) && !empty($_POST["id"])) {
  if ($_POST["delete"] == true) {
    try
    {
    include './NewPdo.php';
    $sql = "DELETE FROM post WHERE id_post =:idpost";
    // Préparation de la requête avec les marqueurs
    $resultat = $base->prepare($sql);
    $resultat->execute(array('idpost' => $_POST["id"]));
    //echo "Personne supprimée: " . $resultat- >rowCount();
    $resultat->closeCursor();
    }
    catch(Exception $e)
    {
    // message en cas d'erreur
    die('Erreur : '.$e->getMessage());
    }
    if(file_exists($_POST["imagePost"])){
      unlink($_POST["imagePost"]);
    }
    header("Location:index.php");
  }else {
    include './NewPdo.php';
    $sql2 = ('SELECT id_user, titre_post, commentaire_post, image_post, date_post, id_post FROM post WHERE id_post = ?');
    $resultat2 = $base->prepare($sql2);
    $resultat2->execute(array($_POST["id"]));

    while ($donnees = $resultat2->fetch())
    {
      //reconstruit le formulaire a partir des données deja remplie de l'article
      echo '<form action="update.php" method="post" enctype="multipart/form-data">
              <input type="hidden" name="id" value="'.$donnees['id_post'].'"></input>
              <label for="titre"><b>Titre :</b></label></br>
              <input value="'.$donnees['titre_post'].'" type="text" name="titre"></br>
              <label for="commentaire"><b>commentaire :</b></label></br>
              <textarea name="commentaire" rows="8" cols="80">'.$donnees['commentaire_post'].'</textarea></br>
              <label for="image"><b>Image :</b></label></br>
              <img width="300px" height="300px" src="'.$donnees['image_post'].'"></br>
              <input type="hidden" name="imagePost" value="'.$donnees['image_post'].'"></input>
              <input type="file" name="image" value="img"></br></br>
              <input type="submit" name="modif" value="modifier">
          </form>';
    }


  }
}

?>
