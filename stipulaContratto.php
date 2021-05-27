<?php

include_once("GestoreDB.php");

session_start();

if(!isset($_SESSION["id"])){
	die("Accesso negato, login non ancora effettuato");
}

$gestore = new GestoreDB();

if($_POST["tipo_pag"] == "Carta credito"){
	$dati = array("servizio", "tipo_pag", "carta_cred", "cod_cred", "data_scad");
}else{
	$dati = array("servizio", "tipo_pag", "iban");
}

foreach($dati as $value){
	if(!isset($_POST[$value])) die("Alcuni dati non sono stati inseriti!");
}


$gestore->stipulaContratto();

