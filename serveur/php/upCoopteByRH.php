<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

$idcoopte = $request->idcoopte;
$idjob = $request->idjob;
$idstatut = $request->idstatut;

try {
  $bdd = new PDO('mysql:host=localhost;dbname=mycoopt', 'root', 'sourislatoucheblanc');
    $bdd->query('SET NAMES utf8');
} catch (Exception $e) {
   echo '{"Etat":false}';
  die('Erreur : ' . $e->getMessage());
}

$query = $bdd->prepare("UPDATE mycoopt.cooptes SET job = '{$idjob}', statut = '{$idstatut}' WHERE id = '{$idcoopte}'");
$bool = $query->execute();

$id = "SELECT cooptant FROM mycoopt.cooptes WHERE cooptant = '{$idcoopte}'";
$get = $bdd->query($id);
$bid = $get->fetch();
$final = $bid[0];

$a = "SELECT fname FROM mycoopt.cooptes WHERE id = '{$idcoopte}'";
$ser = $bdd->query($a);
$fin = $ser->fetch();
$name = $fin[0];

if ($idstatut == 10) {
	$pdo = $bdd->prepare("UPDATE mycoopt.cooptants SET exp = exp+30  WHERE id = {$final}");
	$bool2 = $pdo->execute();
	$message = $bdd->prepare("INSERT INTO mycoopt.notifs (notif, cooptant, exp) VALUES ('Jackpot ! Ton coopté {$name} a validé sa période d'essai et tu vas donc prochainement recevoir une prime de 750€ brut.', $final, 30)");
	$message->execute();
}
if ($idstatut == 9) {
	$pdo = $bdd->prepare("UPDATE mycoopt.cooptants SET exp = exp+25  WHERE id = {$final}");
	$bool2 = $pdo->execute();
	$message = $bdd->prepare("INSERT INTO mycoopt.notifs (notif, cooptant, exp) VALUES ('Félicitations ! Ton coopté {$name} fait partie de nos équipes ', $final, 25)");
	$message->execute();
}
if ($idstatut == 8) {
	$pdo = $bdd->prepare("UPDATE mycoopt.cooptants SET exp = exp+20  WHERE id = {$final}");
	$bool2 = $pdo->execute();
	$message = $bdd->prepare("INSERT INTO mycoopt.notifs (notif, cooptant, exp) VALUES ('Félicitations ! Ton coopté {$name} va bientôt rejoindre nos équipes ;)', $final, 20)");
	$message->execute();
}
if ($idstatut == 7) {
	$pdo = $bdd->prepare("UPDATE mycoopt.cooptants SET exp = exp+15  WHERE id = {$final}");
	$bool2 = $pdo->execute();
	$message = $bdd->prepare("INSERT INTO mycoopt.notifs (notif, cooptant, exp) VALUES ('Nous avons envie de travailler avec ton coopté {$name} et un processus de recrutement sur profil est en court.', $final, 15)");
	$message->execute();
}
if ($idstatut == 6) {
	$pdo = $bdd->prepare("UPDATE mycoopt.cooptants SET exp = exp+15  WHERE id = {$final}");
	$bool2 = $pdo->execute();
	$message = $bdd->prepare("INSERT INTO mycoopt.notifs (notif, cooptant, exp) VALUES ('Nous avons envie de travailler avec ton coopté {$name} et mettons tout en oeuvre pour lui trouver un projet correspondant à ses attentes.', $final, 15)");
	$message->execute();
}
if ($idstatut == 5) {
	$pdo = $bdd->prepare("UPDATE mycoopt.cooptants SET exp = exp+10  WHERE id = {$final}");
	$bool2 = $pdo->execute();
	$message = $bdd->prepare("INSERT INTO mycoopt.notifs (notif, cooptant,exp) VALUES ('Bonne nouvelle ! Ton coopté {$name} a rendez-vous prochainement dans nos locaux pour un deuxième entretien.', $final, 10)");
	$message->execute();
}
if ($idstatut == 4) {
	$pdo = $bdd->prepare("UPDATE mycoopt.cooptants SET exp = exp+10  WHERE id = {$final}");
	$bool2 = $pdo->execute();
	$message = $bdd->prepare("INSERT INTO mycoopt.notifs (notif, cooptant, exp) VALUES ('Bonne nouvelle ! Ton coopté {$name} a rendez-vous prochainement dans nos locaux pour un entretien.', $final, 10)");
	$message->execute();
}
if ($idstatut == 3) {
	$pdo = $bdd->prepare("UPDATE mycoopt.cooptants SET exp = exp+5  WHERE id = {$final}");
	$bool2 = $pdo->execute();
	$message = $bdd->prepare("INSERT INTO mycoopt.notifs (notif, cooptant, exp) VALUES ('Ton coopté {$name} correspond à notre cible, nous l appelons dans les meilleurs délais !', $final, 5)");
	$message->execute();
}

if ($bool === true){echo '{"Etat":true}';} else {echo '{"Etat":false}';}

$bdd = null;

?>