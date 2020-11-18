<?php
  //PAGE DE CONNEXION

  session_start();

  //verifie les valeurs recuperé
  if (isset($_POST["login"]) && isset($_POST["mdp"])) {
    checkLogin($_POST["login"],$_POST["mdp"]);
  }
  else {
    header("Location:connexion.php?login=false");
  }

  //Check si le compte existe
  function checkLogin($login='',$pass=''){
    //crypte le mot de passe
    $password = hash('SHA256', $pass);
    include './NewPdo.php';
    try{
      $sql = "SELECT login, password, id_user FROM user WHERE login = ? AND password = ?";
      // Préparation de la requête avec les marqueurs
      $resultat = $base->prepare($sql);
      $resultat->execute(array($login,$password));
      while ($ligne = $resultat->fetch())
      {
        $userId = $ligne[2];
        $userName = $ligne[0];
      }
      //si le compte existe se connecter en session
      if ($resultat->rowCount() > 0) {
        $_SESSION['login'] = 'yes';
        $_SESSION['id_user'] = $userId;
        $_SESSION['id_name'] = $userName;
        header("Location:pageCreation.php?login=true");
      }else{
        //si le compte n'existe pas ramene a la page formulaire
        $_SESSION['login'] = 'no';
        header("Location:connexion.php?login=false");
      }
      $resultat->closeCursor();
      }
      catch(Exception $e){
      // message en cas d'erreur
      die('Erreur : '.$e->getMessage());
      }
  }
?>
