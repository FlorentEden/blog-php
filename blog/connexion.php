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
        color: white;
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
    </style>
  </head>
  <body>
    <?php
      //gestion des erreurs
      if (isset($_GET["login"]) && $_GET["login"]=="false") {
        echo "login incorrect";
      }else if (isset($_GET["create"]) && $_GET["create"]=="exist") {
        echo "ce compte existe deja";
      }else if (isset($_GET["create"]) && $_GET["create"]=="ok") {
        echo "compte crée avec succes";
      }
    ?>
    <a href="index.php">acceuil</a>
    <div class="login">
      <!--Formulaire de Connexion-->
      <form class="form" action="check.php" method="post" enctype="multipart/form-data">
        <h2>Connexion</h2>
        <label for="login">nom :</label></br>
        <input type="text" name="login"></br></br>
        <label for="mdp">mot de passe :</label></br>
        <input type="password" name="mdp"></br></br>
        <input class="sub" type="submit" name="ok" value="Envoyer">
      </form>
      </br>
      </br>
      <!--Formulaire de Creation de compte-->
      <form class="form" action="createAccount.php" method="post" enctype="multipart/form-data">
        <h2>Inscription</h2>
        <label for="login">nom :</label></br>
        <input type="text" name="login"></br></br>
        <label for="mdp">mot de passe :</label></br>
        <input type="password" name="mdp"></br></br>
        <input class="sub" type="submit" name="ok" value="Envoyer">
      </form>
    </div>
  </script>
</html>
