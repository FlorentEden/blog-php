<?php
  $base = new PDO('mysql:host=127.0.0.1;dbname=blog', 'root', 'root');
  $base->exec("SET NAMES utf8");
  $base->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
?>
