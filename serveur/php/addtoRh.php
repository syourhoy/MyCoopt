<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

$id = $request->login;

try {
  $bdd = new PDO('mysql:host=localhost;dbname=mycoopt', 'root', 'sourislatoucheblanc');
} catch (Exception $e) {
  die('Erreur : ' . $e->getMessage());
}

$req = $bdd->prepare("UPDATE cooptants SET role = 2 WHERE login = '{$id}'");
$bol = $req->execute();
if ($bol === true) {
	echo '{"Etat":true}';
}
else {
	echo '{"Etat":false}';
}

$bdd= null;
?>
