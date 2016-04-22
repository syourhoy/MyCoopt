<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

try {
    $bdd = new PDO('mysql:host=localhost;dbname=mycoopt', 'root', 'sourislatoucheblanc');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

$sql = "SELECT cooptes.id, cooptants.id, cooptes.lname, cooptes.fname, cooptes.cv, cooptants.fname AS fcoopt, cooptants.lname AS lcoopt, cooptes.id AS coopte_id, cooptants.id AS cooptant_id, cooptes.origin, cooptes.fromm FROM cooptes, cooptants WHERE rh = '0' AND cooptes.cooptant = cooptants.id";
$pdo = $bdd->query($sql);
$res = $pdo->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($res, true);

$bdd = null;
?>
