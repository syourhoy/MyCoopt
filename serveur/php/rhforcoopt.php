<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

$idrh = $request->id_rh;
$idcoopte = $request->id_coopte;

try {
  $bdd = new PDO('mysql:host=localhost;dbname=mycoopt', 'root', 'sourislatoucheblanc');
} catch (Exception $e) {
  die('Erreur : ' . $e->getMessage());
}

$prep = $bdd->prepare("UPDATE cooptes SET rh = {$idrh} WHERE id = {$idcoopte}");
$res = $prep->execute();

$bdd = null;

?>
