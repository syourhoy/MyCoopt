<?php
session_start();
$res = $_SESSION['login'];
echo json_encode(array("Login"=>$res));
?>