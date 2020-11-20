<?php
//PAGE CREATION DE BLOG

session_start();

//verifie si est bien connecté
if ($_SESSION['login'] == 'no') {
  header("Location:form.php");
}

//verifie les valeurs envoyés
if ((isset($_POST["titre"]) && !empty($_POST["titre"])) &&
    (isset($_POST["commentaire"]) && !empty($_POST["commentaire"])) &&
    (isset($_FILES["image"]) && !empty($_FILES["image"]))
) {
  //verifie les erreurs des images
  if ($_FILES['image']['error']) {
    switch ($_FILES['image']['error']){
      case 1: header("Location:pageCreation.php?publie=ImageToBig");
      break;
      case 2: header("Location:pageCreation.php?publie=ImageToBig");
      break;
      case 3: //echo "L'envoi du fichier a été interrompu pendant le transfert.";
      break;
      case 4: //echo "La taille du fichier que vous avez envoyé est nulle." ;
      break;
    }
    }
    else {
      //si il n'y a pas d'erreur commencer l'upload
      if ((isset($_FILES['image']['name'])&&($_FILES['image']['error'] == UPLOAD_ERR_OK))) {
        $extensionValid = ["png","jpg","jpeg","gif","tif"];
        //recupere les extensions
        $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        //verifie l'extension
        if (!in_array($extension, $extensionValid)) {
          header("Location:pageCreation.php?publie=notImage");
        }
        $chemin_destination = 'upload/'.uniqid().'.'.$extension;
        //upload le fichier
        move_uploaded_file($_FILES['image']['tmp_name'], $chemin_destination);
        //appelle la requete d'insertion
        creecompte($_POST["titre"],$_POST["commentaire"],$chemin_destination);
      }
      else {
        header("Location:pageCreation.php?publie=false");
      }
    }

}else {
  header("Location:pageCreation.php?publie=false");
}

//creation de l'article
function creecompte($titre='',$commentaire='',$image='')
{
  include './NewPdo.php';
  try{
      $password = hash('SHA256', $pass);
      $sql = "INSERT INTO post (id_post, id_user, titre_post, commentaire_post, image_post, date_post) VALUES (:idpost, :iduser, :titre, :commentaire, :image, :datee)";
      // Préparation de la requête avec les marqueurs
      $resultat = $base->prepare($sql);
      $resultat->execute(array('idpost' => uniqid(), 'iduser' => $_SESSION['id_user'],'titre' => htmlspecialchars($titre),'commentaire' => htmlspecialchars($commentaire),'image' => $image,'datee' => date("d-m-y h:i:s")));
      header("Location:index.php?publie=true");
      $resultat->closeCursor();
    }
    catch(Exception $e){
      // message en cas d'erreur
      die('Erreur : '.$e->getMessage());
    }
}

?>
