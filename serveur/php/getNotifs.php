<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

try {
  $bdd = new PDO('mysql:host=localhost;dbname=mycoopt', 'root', 'sourislatoucheblanc');
    $bdd->query('SET NAMES utf8');
} catch (Exception $e) {
   echo '{"Etat":false}';
  die('Erreur : ' . $e->getMessage());
}

session_start();
$login = $_SESSION['login'];

$a = "SELECT id FROM mycoopt.cooptants WHERE login = '{$login}'";
$ser = $bdd->query($a);
$fin = $ser->fetch();
$name = $fin[0];

$sql = "SELECT DISTINCT notif,exp FROM mycoopt.notifs WHERE cooptant = {$name}";
$pdo = $bdd->query($sql);
$res = $pdo->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($res, true);

$bdd = null;

?>
