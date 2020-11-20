<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <style media="screen">
      body{
        background-color: #00acee;
        color: #00acee;
        font-family: 'Roboto', sans-serif;
      }
      .login{
        display: flex;
        justify-content: center;
      }
      .form{
        width: 300px;
        margin: 150px 100px 150px 100px;
      }

      input{
        margin-top: 5px;
        padding: 7px;
        border: 0px;
        border-radius: 23px;
        color: #00acee;
      }

      .sub{
        cursor: pointer;
      }
      .articles{
        width: 800px;
        display: flex;
        justify-content: center;
        flex-direction: column-reverse;
      }
      .article{
        padding: 20px;
        border-radius: 27px;
        background-color: lightpink;
        margin: 20px 50px 20px 50px;
        text-align: center;
        box-shadow: -10px 0px 30px -7px pink, 10px 0px 30px -7px pink, 5px 5px 41px 36px rgba(0,0,0,0);
      }
      .imgs{
        margin-left: auto;
        margin-right: auto;
        width: 90%;
        height: 300px;
        background-image: url("upload/5fb5366927f1e.jpg");
        background-position: center;
        background-repeat: no-repeat;
        background-size: contain;
      }
      .adminChange{
      }
    </style>
  </head>
  <body>
    <?php
      if ($_SESSION['login'] == 'no') {
        echo '<a href="connexion.php">se connecter</a>';
      }else if ($_SESSION['login'] == 'yes') {
        echo '<a href="pageCreation.php">creer article</a></br>';
        echo '<a href="deconnexion.php">deconexion</a></br>';
        echo 'bonjour '.$_SESSION['id_name'].' !';
      }
      echo "<div class='articles'>";
      include './NewPdo.php';
      try
      {
        // Récupèration des données de la table post
        $resultat = $base->query('SELECT id_user, titre_post, commentaire_post, image_post, date_post, id_post FROM post');
        // Affichage de chaques entrées une à une
        while ($donnees = $resultat->fetch())
        {
          //Affichage de l'article
          $sql2 = "SELECT login FROM user WHERE id_user = ?";
          $resultat2 = $base->prepare($sql2);
          $resultat2->execute(array($donnees['id_user']));
          while ($ligne2 = $resultat2->fetch())
          {
          $newDate = date("d-m-Y - h:i:s", strtotime($donnees['date_post']));
          echo "<div class='article'>
                    par: ".$ligne2[0]."
                    le <b>".$newDate."</b>
                    <h5>".$donnees['titre_post']."</h5>
                    <p>".$donnees['commentaire_post']."</p>
                    <p class='imgs' style='background-image: url(".$donnees['image_post'].");'></p>";
            //si l'article est fait par l'utilisateur connecté ajouter un bouton modifier
            if ($donnees['id_user'] == $_SESSION['id_user']) {
              echo '<form class="adminChange" action="userPost.php" method="post" enctype="multipart/form-data">
                      <input type="hidden" name="id" value="'.$donnees['id_post'].'"></input>
                      <input type="hidden" name="imagePost" value="'.$donnees['image_post'].'"></input>
                      <input class="sub" type="submit" name="ok" value="modifier">
                      <input class="sub" type="submit" name="delete" value="supprimer">
                    </form>';
            }
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
      echo "</div>";
    ?>
  </body>
</html>
