<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

$login = $request->login;
$pass = $request->mdp;
$mail = $request->mail;
$fname = $request->fname;
$lname = $request->lname;
$agence = $request->agence;

try {
  $bdd = new PDO('mysql:host=localhost;dbname=mycoopt', 'root', 'sourislatoucheblanc');
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
	    }

$check = "SELECT login FROM mycoopt.cooptants WHERE login = '{$login}';";
$res = $bdd->query($check);
$final = $res->fetchAll(PDO::FETCH_ASSOC);

$check2 = "SELECT mail FROM mycoopt.cooptants WHERE mail = '{$mail}';";
$res2 = $bdd->query($check2);
$final2 = $res2->fetchAll(PDO::FETCH_ASSOC);

if (empty($final) && empty($final2)) {
   $stmt = $bdd->prepare("INSERT INTO mycoopt.cooptants (login, pwd, lname, fname, agence, mail, picture, exp, role) VALUES ('{$login}', '{$pass}', '{$fname}', '{$lname}', '{$agence}', '{$mail}', '../asset/img/avatar.png', 0, 3)");
        $test = $stmt->execute();
        session_start();
	$_SESSION['login'] = $login;
	    echo json_encode(array('Etat'=> true));
        } else if (!empty($final2)) {
	    echo json_encode(array('Etat'=> false, 'Erreur' => mail));
        } else {
            echo json_encode(array('Etat'=> false, 'Erreur' => login));
        }

$bdd = null;

?>