<?php

session_start();

if ($_SESSION['login'] == 'no') {
  header("Location:form.php");
}

if ((isset($_POST["titre"]) && !empty($_POST["titre"])) &&
    (isset($_POST["commentaire"]) && !empty($_POST["commentaire"]))
) {
  if (isset($_FILES["image"]) && !empty($_FILES["image"])) {
    if ($_FILES['image']['error']) {
      switch ($_FILES['image']['error']){
        case 1: header("Location:userPost.php?modif=ImageToBig");
        break;
        case 2: header("Location:userPost.php?modif=ImageToBig");
        break;
        case 3: //echo "L'envoi du fichier a été interrompu pendant le transfert.";
        break;
        case 4: //echo "La taille du fichier que vous avez envoyé est nulle." ;
        break;
      }
      //appelle la fonction pour update sans l'image
      modifCompteNotimg($_POST["titre"],$_POST["commentaire"],$_POST["id"]);
    }else {
      //si l'image a été modifié et qu'il n'y a pas d'erreur commencer l'upload
        if ((isset($_FILES['image']['name'])&&($_FILES['image']['error'] == UPLOAD_ERR_OK))) {
          $extensionValid = ["png","jpg","jpeg","gif","tif"];
          //recupere les extensions
          $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
          //verifie l'extension
          if (!in_array($extension, $extensionValid)) {
            header("Location:userPost.php?modif=notImage");
          }
          $chemin_destination = 'upload/'.uniqid().'.'.$extension;
          //upload le fichier
          move_uploaded_file($_FILES['image']['tmp_name'], $chemin_destination);
          //appelle la requete de modification de l'image
          if(file_exists($_POST["imagePost"])){
            unlink($_POST["imagePost"]);
          }
          modifCompteimg($chemin_destination,$_POST["id"]);
        }
          else {
            header("Location:userPost.php?modif=false");
          }
        }

  }else {

  }
}
else {
  header("Location:userPost.php?modif=false");
}


function modifCompteimg($image='',$idpost='')
{
  include './NewPdo.php';
  try{

      $sql = "UPDATE post SET image_post = :image WHERE id_post = :idpost";
      // Préparation de la requête avec les marqueurs
      $resultat = $base->prepare($sql);
      $resultat->execute(array('image' => $image, 'idpost' => $idpost));
      header("Location:index.php?modif=true");
      $resultat->closeCursor();
    }
    catch(Exception $e){
      // message en cas d'erreur
      die('Erreur : '.$e->getMessage());
    }
}

function modifCompteNotimg($titre='',$commentaire='',$idpost='')
{
  include './NewPdo.php';
  try{
      $sql = "UPDATE post SET titre_post = :titre, commentaire_post = :commentaire WHERE id_post = :idpost";
      // Préparation de la requête avec les marqueurs
      $resultat = $base->prepare($sql);
      $resultat->execute(array('titre' => htmlspecialchars($titre), 'commentaire' => htmlspecialchars($commentaire), 'idpost' => $idpost));
      header("Location:index.php?modif=true");
      $resultat->closeCursor();
    }
    catch(Exception $e){
      // message en cas d'erreur
      die('Erreur : '.$e->getMessage());
    }
}

?>
