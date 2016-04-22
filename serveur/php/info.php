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

$query = "SELECT * FROM mycoopt.cooptants WHERE login = '{$login}'";
$pdo = $bdd->query($query);
$res = $pdo->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($res);

$bdd = null;

?>