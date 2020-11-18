<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <style media="screen">
    body{
    }
      div{
        margin: 30px;
        border: 3px solid black;
        width: 500px;
        text-align: center;
      }
    </style>
  </head>
  <body>
    <?php
      if ($_SESSION['login'] == 'no') {
        echo '<a href="connexion.php">se connecter</a>';
      }else if ($_SESSION['login'] == 'yes') {
        echo '<a href="pageCreation.php">creer article</a></br>';
        echo 'bonjour '.$_SESSION['id_name'].' !';
      }

      include './NewPdo.php';
      try
      {
        // Récupèration des données de la table post
        $resultat = $base->query('SELECT id_user, titre_post, commentaire_post, image_post, date_post FROM post');
        // Affichage de chaques entrées une à une
        while ($donnees = $resultat->fetch())
        {
          //Affichage de l'article
          echo "<div>
          <p>".$donnees['date_post']."</p>
          <h5>".$donnees['titre_post']."</h5>
          <p>".$donnees['commentaire_post']."</p>
          <img width='300px' height='300px' src='".$donnees['image_post']."'></br>";
          $sql2 = "SELECT login FROM user WHERE id_user = ?";
          $resultat2 = $base->prepare($sql2);
          $resultat2->execute(array($donnees['id_user']));
          while ($ligne2 = $resultat2->fetch())
          {
            echo 'par: '.$ligne2[0].'</br>';
            //si l'article est fait par l'utilisateur connecté ajouter un bouton modifier
            if ($donnees['id_user'] == $_SESSION['id_user']) {
              echo "<button>modifier</button>";
            }
          echo "</div></br>";
        }
        $resultat->closeCursor(); // Fermeture de la requête
      }
      catch(Exception $e)
      {
      // message en cas d'erreur
      die('Erreur : '.$e->getMessage());
      }
    ?>
  </body>
</html>
