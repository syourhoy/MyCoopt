<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

if ($request->genre != ""){$genre = $request->genre;} else {$genre = "undefined";} 
if ($request->commend != ""){$reco = $request->commend;} else {$reco = "undefined";}
if ($request->firstname != ""){$fname = $request->firstname;} else {$fname = "undefined";}
if ($request->lastname != ""){$lname = $request->lastname;} else {$lname = "undefined";}
if ($request->student != ""){$student = $request->student;} else {$student = "undefined";}
if ($request->origin != ""){$origin = $request->origin;} else {$origin = "undefined";}
if ($request->fromm != ""){$fromm = $request->fromm;} else {$fromm = "undefined";}

session_start();
// $_SESSION['login'] = 'Cgraux';
$login = $_SESSION['login'];

try {
  $bdd = new PDO('mysql:host=localhost;dbname=mycoopt', 'root', 'sourislatoucheblanc');
} catch (Exception $e) {
   echo "{'Etat':true}";  
  die('Erreur : ' . $e->getMessage());
}

$id = "SELECT id FROM mycoopt.cooptants WHERE login = '{$login}'";
$get = $bdd->query($id);
$bid = $get->fetch();
$final = $bid[0];
$stmt = $bdd->prepare("INSERT INTO mycoopt.cooptes (fname, lname, genre, commend, student, origin, fromm, cooptant, creation_date, job, statut, rh, cv) 
VALUES ('{$fname}', '{$lname}', '{$genre}', '{$reco}', '{$student}', '{$origin}', '{$fromm}', {$final}, NOW(), 1, 1, 0, '../serveur/cv/modele-cv.pdf')");
$test = $stmt->execute();

$bdd = null;

?>