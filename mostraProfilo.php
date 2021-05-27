<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once("GestoreDB.php");

session_start();

$gestore = new GestoreDB();

if(isset($_SESSION["id"])){
	$gestore->mostraProfilo();
}else{
	die("Accesso negato");
}