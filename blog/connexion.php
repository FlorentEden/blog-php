<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
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
    <!--Formulaire de Connexion-->
    <form action="check.php" method="post" enctype="multipart/form-data">
      <h2>Connexion</h2>
      <label for="login">nom</label>
      <input type="text" name="login">
      <label for="mdp">mot de passe</label>
      <input type="password" name="mdp">
      <input type="submit" name="ok" value="Envoyer">
    </form>
    </br>
    </br>
    <!--Formulaire de Creation de compte-->
    <form action="createAccount.php" method="post" enctype="multipart/form-data">
      <h2>Inscription</h2>
      <input type="text" name="login">
      <input type="password" name="mdp">
      <input type="submit" name="ok" value="Envoyer">
    </form>
  </script>
</html>
