<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once("GestoreDB.php");

$gestore = new GestoreDB();
if(isset($_POST['email']) && isset($_POST['password'])){
	$gestore->login();
}else{
	die("Campi non settati!");
}