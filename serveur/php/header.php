<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

session_start();
if (!isset($_SESSION['login'])) {
    echo json_encode('{"Etat":false}');
		die();
}
$login = $_SESSION['login'];

try {
  $bdd = new PDO('mysql:host=localhost;dbname=mycoopt', 'root', 'sourislatoucheblanc');
} catch (Exception $e) {
  die('Erreur : ' . $e->getMessage());
}

$sql = "SELECT lname,fname,exp,picture,role FROM mycoopt.cooptants WHERE login = '{$login}'";

$pdo = $bdd->query($sql);
$res = $pdo->fetchAll();

$arr = array ("nom"=>$res[0]['lname'], "prenom"=>$res[0]['fname'], "xp"=>$res[0]['exp'], "img"=>$res[0]['picture'], "role"=>$res[0]['role'], "login"=>$login, "Etat"=>true);

echo json_encode($arr);

$bdd = null;

?>
