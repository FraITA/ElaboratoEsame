<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once("GestoreDB.php");

$gestore = new GestoreDB();

if(isset($_GET["id_contatore"]) && isset($_GET["cons_totale"]) && isset($_GET["data"])){
	$gestore->effettuaConsumo();
}