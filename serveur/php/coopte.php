<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

session_start();
$login = $_SESSION['login'];


try {
    $bdd = new PDO('mysql:host=localhost;dbname=mycoopt', 'root', 'sourislatoucheblanc');
    $bdd->query('SET NAMES utf8');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

$id = "SELECT id FROM mycoopt.cooptants WHERE login = '{$login}'";
$get = $bdd->query($id);
$bid = $get->fetch();
$final = $bid[0];
$sql = "SELECT DISTINCT cooptes.*, statuts.rh AS statut_rh, statuts.cooptant AS statut_cooptant FROM mycoopt.cooptes, mycoopt.statuts  WHERE cooptes.cooptant = '$final' AND cooptes.statut = statuts.id ORDER BY cooptes.creation_date DESC";
$pdo = $bdd->query($sql);
$res = $pdo->fetchAll(PDO::FETCH_ASSOC);
//echo count($res);
for($i = 0; $i < count($res); $i++) {
    $res[$i]['statut_cooptant'] = preg_replace('/#/', $res[$i]['fname'], $res[$i]['statut_cooptant']);
}

echo json_encode($res, true);

$bdd = null;

?>

