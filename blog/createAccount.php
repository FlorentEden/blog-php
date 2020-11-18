<?php
  //PAGE DE CREATION DE COMPTE

  session_start();

  //verifie les valeurs recuperé
  if ((isset($_POST["login"]) && !empty($_POST["login"])) &&
      (isset($_POST["mdp"]) && !empty($_POST["mdp"]))
  ) {
    creecompteCheck($_POST["login"],$_POST["mdp"]);
  }else {
    header("Location:connexion.php?login=false");
  }

  //Check si le compte existe deja
  function creecompteCheck($login='',$pass=''){
    include './NewPdo.php';
    try{
      //crypte le mot de passe
      $password = hash('SHA256', $pass);
      echo " $password";
      $sql = "SELECT login, password, id_user FROM user WHERE login = ? AND password = ?";
      // Préparation de la requête avec les marqueurs
      $resultat = $base->prepare($sql);
      $resultat->execute(array($login,$password));
      if ($resultat->rowCount() > 0) {
        //Si le compte existe deja ramene au formulaire
        header("Location:connexion.php?create=exist");
      }else{
        //Si le compte n'existe pas appele la fonction de creation de compte
        creecompte($_POST["login"],$_POST["mdp"]);
        //ramene a la page formulaire
        header("Location:connexion.php?create=ok");
      }
      $resultat->closeCursor();
      }
      catch(Exception $e){
        // message en cas d'erreur
        die('Erreur : '.$e->getMessage());
      }
  }

  //Creer un compte
  function creecompte($login='',$pass='')
  {
    include './NewPdo.php';
    try{
        $password = hash('SHA256', $pass);
        $sql = "INSERT INTO user (id_user, login, password) VALUES (:id_user, :login, :password)";
        // Préparation de la requête avec les marqueurs
        $resultat = $base->prepare($sql);
        $resultat->execute(array('id_user' => uniqid(),'login' => htmlspecialchars($login),'password' => htmlspecialchars($password)));
        /*echo "L'identifiant de la dernière personne ajoutée est:";
        echo $base->lastInsertId().".";*/
        $resultat->closeCursor();
      }
      catch(Exception $e){
        // message en cas d'erreur
        die('Erreur : '.$e->getMessage());
      }
  }
