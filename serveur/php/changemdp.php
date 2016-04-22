<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$postdata = file_get_contents("php://input");
$data = json_decode($postdata);

$old = $data->oldmdp;
$newp = $data->newmdp;
$okmdp = $data->okmdp;

session_start();
$login = $_SESSION['login'];

try {
    $bdd = new PDO('mysql:host=localhost;dbname=mycoopt', 'root', 'sourislatoucheblanc');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

$sql = "SELECT pwd FROM mycoopt.cooptants WHERE login = '{$login}'";
$pdo = $bdd->query($sql);
$res = $pdo->fetch();
if ($old === $res['pwd'] && $okmdp === $newp) {
   $cmd = "UPDATE mycoopt.cooptants SET pwd = '{$newp}' WHERE login = '{$login}'";
   $change = $bdd->query($cmd);
   $json = '{"Etat":true}';
   echo $json;
}else {
   $json = '{"Etat":false}';
   echo $json;
}

$bdd = null;

?>