<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

session_start();
$login = $_SESSION['login'];


try {
    $bdd = new PDO('mysql:host=localhost;dbname=mycoopt', 'root', 'sourislatoucheblanc');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

$id = "SELECT ID FROM mycoopt.cooptants WHERE login = '{$login}'";
$get = $bdd->query($id);
$bid = $get->fetch();
$final = $bid[0];
$sql = "SELECT DISTINCT cooptes.* FROM mycoopt.cooptes WHERE {$final} = cooptes.rh ORDER BY cooptes.creation_date DESC";
$pdo = $bdd->query($sql);
$res = $pdo->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($res, true);

$bdd = null;

?>