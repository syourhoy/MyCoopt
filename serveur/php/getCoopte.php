<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

try {
  $bdd = new PDO('mysql:host=localhost;dbname=mycoopt', 'root', 'sourislatoucheblanc');
} catch (Exception $e) {
  die('Erreur : ' . $e->getMessage());
}

session_start();
$login = $_SESSION['login'];

$id = "SELECT lname,fname FROM mycoopt.cooptes WHERE cooptants = '{$login}'";
$get = $bdd->query($id);
$res = $get->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($res);

$bdd = null;
?>