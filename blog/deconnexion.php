<?php
  session_start();
  $_SESSION['login'] = 'no';
  $_SESSION['id_user'] = '0';
  $_SESSION['id_name'] = 'nill';
  header("Location:connexion.php");
?>
