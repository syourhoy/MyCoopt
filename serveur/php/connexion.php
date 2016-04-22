<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$postdata = file_get_contents("php://input");
$data = json_decode($postdata);

$login = $data->login;
$pass = $data->mdp;

try {
    $bdd = new PDO('mysql:host=localhost;dbname=mycoopt', 'root', 'sourislatoucheblanc');
} catch (Exception $e){
  die('Erreur : ' . $e->getMessage());
}

$sql = "SELECT pwd FROM mycoopt.cooptants WHERE login = '{$login}'";
$pdo = $bdd->query($sql);
$res = $pdo->fetch();
if ($pass === $res['pwd']) {
   session_start();
   $_SESSION['login'] = $login;
  $json = '{"Etat":true}';
  echo $json;
}
elseif ($pass !== $res['pwd']) {
  $json = '{"Etat":false}';
  echo $json;
}

$bdd = null;

?>
