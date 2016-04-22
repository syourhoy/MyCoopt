<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

try {
  $bdd = new PDO('mysql:host=localhost;dbname=mycoopt', 'root', 'sourislatoucheblanc');
} catch (Exception $e) {
  die('Erreur : ' . $e->getMessage());
}

$sql = "SELECT lname,fname,id FROM mycoopt.cooptants WHERE role = 2";
$pdo = $bdd->query($sql);
$res = $pdo->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($res);

$bdd = null;

?>
