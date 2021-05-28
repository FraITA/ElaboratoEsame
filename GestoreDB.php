<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Gestoredb
 *
 * @author user
 */
class GestoreDB {
	
	private function mostraTesta($titolo){
		$head=file("htmlContent/headTop.html"); //leggo il file che contiene la parte di mezzo della mia pagina web
		foreach ( $head as $row ) {
			echo($row); //trasmetto la risposta come documento HTML (corpo)
		}
		echo($titolo);
		$head=file("htmlContent/headBottom.html"); //leggo il file che contiene la parte di mezzo della mia pagina web
		foreach ( $head as $row ) {
			echo($row); //trasmetto la risposta come documento HTML (corpo)
		}
	}
	
	public function mostraRegistrazione(){
		$this->mostraTesta("Registrazione");
		$body=file("htmlContent/registrazione.html"); //leggo il file che contiene la parte di mezzo della mia pagina web
		foreach ( $body as $row ) {
			echo($row); //trasmetto la risposta come documento HTML (corpo)
		}
		$this->mostraCoda();
	}
	
	public function mostraHomePage(){
		$this->mostraTesta("Home page");
		$this->mostraNavbar();
		
		$data = $this->getLivelli();
		
		foreach($data as $row){
			if($row["livello"]<($row["capacita"]/3)){
				echo("<p style='color: red'> Cisterna situata a " . $row["via"] . ' ' . $row["num_civ"] . ', ' . $row["comune"] . ', ' . $row["provincia"] . " con livello inferiore a " . $row["capacita"]/3 . " litri su " . $row["capacita"] . " (" . $row["livello"] . " litri)  </p>");
			}
		}
		
		echo("<img class='.img-fluid' style='max-width: 100%; height: auto;' src='images/homeImage.png'>");
		
		$this->mostraCoda();
	}
	
	private function mostraNavbar(){
		$body=file("htmlContent/navbarTop.html"); //leggo il file che contiene la parte di mezzo della mia pagina web
		foreach ( $body as $row ) {
			echo($row); //trasmetto la risposta come documento HTML (corpo)
		}
		echo($_SESSION["email"]);
		$body=file("htmlContent/navbarBottom.html"); //leggo il file che contiene la parte di mezzo della mia pagina web
		foreach ( $body as $row ) {
			echo($row); //trasmetto la risposta come documento HTML (corpo)
		}
	}
	
	private function mostraCoda(){
		$tail=file("htmlContent/tail.html"); //leggo il file che contiene la parte di mezzo della mia pagina web
		foreach ( $tail as $row ) {
			echo($row); //trasmetto la risposta come documento HTML (corpo)
		}
	}
	
	private function mostraContrattoTop(){
		$body=file("htmlContent/formContrattoTop.html"); //leggo il file che contiene la parte di mezzo della mia pagina web
		foreach ( $body as $row ) {
			echo($row); //trasmetto la risposta come documento HTML (corpo)
		}
	}
	
	private function mostraContrattoBottom(){
		$body=file("htmlContent/formContrattoBottom.html"); //leggo il file che contiene la parte di mezzo della mia pagina web
		foreach ( $body as $row ) {
			echo($row); //trasmetto la risposta come documento HTML (corpo)
		}
	}
	
	public function mostraFormContratto(){
		$this->mostraTesta("Stipula contratto");
		$this->mostraNavbar();
		$this->mostraContrattoTop();

		$this->getServizi();
		
		$this->mostraContrattoBottom();
		$this->mostraCoda();
	}
	
	public function mostraPagamenti(){
		$this->mostraTesta("Mostra pagamenti");
		$this->mostraNavbar();
		
		//Stampo il ocontenuto HTML per mostrare i pagamenti
		echo("<div class='container-md'>");
		echo("<div class='row'>");
		echo("<div class='col-2'> <label for='servizio'> Servizio: </label> </div>");
		echo("<div class='col-2'> <select id='servizio' onchange='getPagamenti(this)'>");
		echo("<option value='' id='delete'> </option>");
		$this->getServizi();
		echo("</select> </div>");
		echo("</div>");
		echo("</div>");
		echo("<div class='container-md'>");
		echo("<div id='pagamenti' class='row col-12'>");
		echo("</div>");
		echo("</div>");
		$this->mostraCoda();
	}
	
	public function mostraLivello(){
		$this->mostraTesta("Livello cisterne");
		$this->mostraNavbar();
		
		echo("<div class='container-md'>");
		$data = $this->getLivelli();
		
		//Stampo su schermo la tabella con tutte le cisterne e i livelli
		echo("<table class='table'>");
		echo("<tr>");
		echo("<th> Livello </th>");
		echo("<th>  </th>");
		echo("<th> Capacità </th>");
		echo("<th> Servizio </th>");
		echo("<th> Indirizzo </th>");
		echo("</tr>");
		foreach($data as $row){
			echo("<tr>");
			echo('<td>' . $row["livello"] . ' Litri </td>');
			echo('<td> / </td>');
			echo('<td>' . $row["capacita"] . ' Litri </td>');
			echo('<td>' . $row["tipo"] . ' </td>');
			echo('<td>' . $row["via"] . ' ' . $row["num_civ"] . ', ' . $row["comune"] . ', ' . $row["provincia"] . '</td>');
			echo("</tr>");
		}
		
		echo("</table>");
		
		echo("</div>");
		
		$this->mostraCoda();
	}
	
	public function mostraProfilo(){
		$this->mostraTesta("Profilo utente");
		$this->mostraNavbar();
		
		$this->getProfilo();
		
		$this->mostraCoda();
	}
	
	//funzione per sanificare gli input, evitando l'esecuzione di possibile codice malevolo
	private function clean_input($value){

		$bad_chars = array("{", "}", "(", ")", ";", ":", "<", ">", "/", "$");

		$value = str_ireplace($bad_chars, "", $value);

		$value = htmlentities($value);

		$value = strip_tags($value);

		return $value;
	}
	
	private function val_input($tipo, $value){
		switch($tipo){
			case "email":
				if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
					die("Formato email non valido!");
				}
				break;
			case "text":
				if(!preg_match("/^[A-Za-zòàèù ]*$/", $value)){
					die("Formato testo non valido!");
				}
				break;
			case "number":
				if(!preg_match("/^[0-9]*$/", $value)){
					die("Formato numero non valido!");
				}
				break;
			case "alphanumeric":
				if(!preg_match("/^[A-Za-zòàèù0-9]*$/", $value)){
					die("Formato alfanumerico non valido!");
				}
				break;
			case "date":
				if(!preg_match("/^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$/", $value)){
					die("Formato data non valido");
				}
				break;
			case "num_civ":
				if(!preg_match("/^[0-9A-Z\/]+$/", $value)){
					die("Formato numero civico non valido");
				}
				break;
			case "num_carta":
				if(!preg_match("/^[0-9]{16}$/", $value)){
					die("Formato numero carta di credito non valido");
				}
				break;
			case "cod_carta":
				if(!preg_match("/^[0-9]{3}$/", $value)){
					die("Formato codice carta di credito non valido");
				}
				break;
		}
		
		return $value;
	}
	
	//ottengo il profilo di un utente, basandomi sull'id salvato nella sessione
	private function getProfilo(){
		
		$connessione = $this->connetti();
		
		$query = "SELECT * FROM cliente WHERE cliente.id_cliente = " . $_SESSION["id"];
		
		$response = $connessione->query($query);
		
		$data = $response->fetchAll();
		
		echo("<div class='container-md'>");
		foreach($data as $row){
			//Tolgo i dati che non bisogna mostrare
			unset($row["id_cliente"]);
			unset($row["password"]);
			for($i = 0;$i<12;$i++){
				unset($row[$i]);
			}
			foreach($row as $key => $value){
				echo("<div class='row'>");
				echo("<label class='col-12'>" . $key . " : " . $value . "</label>");
				echo("</div>");
			}
		}
		echo("</div>");
	}
	
	//Ottengo e stampo tutti i servizi disponibili nel database
	private function getServizi(){
		//Ottengo tutti i servizi dal database
		$connessione = $this->connetti();
		
		$query = "SELECT id_serv,tipo FROM servizio";
		
		$response = $connessione->query($query);
		
		$data = $response->fetchAll();
		
		foreach($data as $row){
			echo('<option value="' . $row["id_serv"] . '"> ' . $row["tipo"] . ' </option>');
		}
	}
	
	//ottengo tutti i pagamenti di un certo cliente in un certo servizio
	public function getPagamenti(){
		
		$value = $this->clean_input($_GET["servizio"]);
		
		$value = $this->val_input("number", $value);
		
		session_start();
		
		$connessione = $this->connetti();
		
		$query	=	'SELECT ROUND(servizio.costo_fisso + (servizio.costo_unit * consumo.cons_totale)) AS importo,
					consumo.cons_totale AS consumo,
					consumo.data,
					contatore.via,
					contatore.num_civ,
					contatore.comune,
					contatore.provincia

					FROM servizio, consumo, contratto, contatore

					WHERE contratto.id_cliente = ' . $_SESSION["id"] . '
					AND contratto.id_serv = ' . $value . '
					AND contratto.id_contatore = consumo.id_contatore
					AND servizio.id_serv = contratto.id_serv
					AND contatore.id_contatore = contratto.id_contatore
					
					ORDER BY consumo.data';
		
		$response = $connessione->query($query);
		
		$data = $response->fetchAll();
		
		$this->mediaConsumi();
		
		echo("<table class='table'>");
		echo("<tr>");
		echo("<th> Importo </th>");
		echo("<th> Consumo </th>");
		echo("<th> Data </th>");
		echo("<th> Indirizzo </th>");
		echo("</tr>");
		foreach($data as $row){
			echo("<tr>");
			echo('<td>' . $row["importo"] . ' €</td>');
			echo('<td>' . $row["consumo"] . ' Litri</td>');
			echo('<td>' . $row["data"] . '</td>');
			echo('<td>' . $row["via"] . ' ' . $row["num_civ"] . ', ' . $row["comune"] . ', ' . $row["provincia"] . '</td>');
			echo("</tr>");
		}
		
		echo("</table>");
	}
	
	private function mediaConsumi(){
		$connessione = $this->connetti();
		
		$value = $this->clean_input($_GET["servizio"]);
		
		$value = $this->val_input("number", $value);
		
		$query	=	'SELECT ROUND(AVG(consumo.cons_totale)) AS consumi_medi FROM consumo, contratto
					WHERE contratto.id_cliente = ' . $_SESSION["id"] . '
					AND contratto.id_serv = ' . $value . '
					AND contratto.id_contatore = consumo.id_contatore';
		
		$response = $connessione->query($query);
		
		$data = $response->fetchAll();	
		
		foreach($data as $row){
			$result = $row["consumi_medi"]>0 ? $row["consumi_medi"] : 0;
			echo('<div class="row col-4">');
			echo('<p> Media consumi: ' . $result . ' Litri</p>');
			echo('</div>');
		}
	}
	
	//Ottengo tutti i livelli attuali delle cisterne di un dato cliente
	private function getLivelli(){
		
		$connessione = $this->connetti();
		
		$query	=	'SELECT cisterna.*, servizio.tipo FROM cisterna, contratto, servizio 
					WHERE contratto.id_cliente = ' . $_SESSION["id"] . '
					AND contratto.id_cisterna = cisterna.id_cisterna
					AND contratto.id_serv = servizio.id_serv';
		
		$response = $connessione->query($query);
		
		$data = $response->fetchAll();
		
		
		return $data;
	}
	
	//effettuo la registrazione
	public function registra(){
		foreach($_POST as $key => $value){
			$value = $this->clean_input($value); //Sanificazione input
		}
		
		$cod_fis	= $this->val_input("alphanumeric", $_POST["cod_fis"]);
		$nome		= $this->val_input("text", $_POST["nome"]);
		$cognome	= $this->val_input("text", $_POST["cognome"]);
		$email		= $this->val_input("email", $_POST["email"]);
		$telefono	= $this->val_input("number", $_POST["telefono"]);
		$via		= $this->val_input("text", $_POST["indirizzo"]);
		$num_civ	= $this->val_input("num_civ", $_POST["num_civ"]);
		$comune		= $this->val_input("text", $_POST["comune"]);
		$provincia	= $this->val_input("text", $_POST["provincia"]);
		$data_nasc	= $this->val_input("date", $_POST["data_nasc"]);
		$pw			= sha1($_POST["password"]);
		
		$connessione = $this->connetti();
		
		$query = 'INSERT INTO cliente (id_cliente, cod_fis, nome, cognome, email, telefono, via, num_civ, comune, provincia, data_nasc, password)';
		$query .='VALUES(NULL, :cod_fis, :nome, :cognome, :email, :telefono, :via, :num_civ, :comune, :provincia, :data_nasc, :password)';
		
		$sql = $connessione->prepare($query);
		$sql->bindParam(":cod_fis", $cod_fis);
		$sql->bindParam(":nome", $nome);
		$sql->bindParam(":cognome", $cognome);
		$sql->bindParam(":email", $email);
		$sql->bindParam(":telefono", $telefono);
		$sql->bindParam(":via", $via);
		$sql->bindParam(":num_civ", $num_civ);
		$sql->bindParam(":comune", $comune);
		$sql->bindParam(":provincia", $provincia);
		$sql->bindParam(":data_nasc", $data_nasc);
		$sql->bindParam(":password", $pw);
		
		$sql->execute();
		
		header("Location: login.php");
		
		//Chiusura connessione
		$connessione = null;
	}
	
	//Effettuo il login
	public function login(){
		session_start();
		
		foreach($_POST as $key => $value){
			$value = $this->clean_input($value); //Sanificazione input
		}
		
		$time = time();
		
		//Dopo 3 tentativi, bisogna aspettare 30 secondi
		if(!empty($_SESSION["tempoInizio"])){
			$intervallo = ($time-$_SESSION["tempoInizio"]) % 60;
			
			if( $intervallo < 30){
				echo("Troppi tentativi, riprova tra " . (30 - $intervallo) . " secondi");
				return;
			}else{
				$_SESSION["nTent"] = 0;
				unset($_SESSION["tempoInizio"]);
			}
		}
		$email = $this->val_input("email", $_POST["email"]);
		$pw = sha1($_POST["password"]);
		
		$connessione = $this->connetti();
		
		$query = 'SELECT id_cliente,email,password,nome,cognome FROM cliente';
		
		$response = $connessione->query($query);
		
		$data = $response->fetchAll();
		
		foreach($data as $row){
			if(($row['email'] == $email) && ($row['password'] == $pw)){ //Controllo se i dati coincidono
				echo("Login effettuato! Benvenuto " . $row["nome"] . " " . $row["cognome"] . "!");
				if(isset($_POST["ricordami"])){
					setcookie("email", $email, time()+60*60*24*30); //Setto il cookie con l'email se ha spuntato la checkbox "ricorda"
				}else{
					setcookie("email", "", time() - 3600);
				}
				//Salvo dati nelle variabili di sessione per identificarlo
				$_SESSION["id"] = $row["id_cliente"];
				$_SESSION["email"] = $row["email"];
				$connessione = null;
				$this->mostraHomePage();
				return;
			}
		}
		
		//Se il login è fallito
		$connessione = null;
		
		//Controll ose ha sbagliato 3 volte e aumento il counter
		$this->controllaTentativi();
		
		//mostro messaggio di errore
		$_SESSION["message"] = "Login fallito, email o password non corretto";
		
		if(isset($_SESSION["id"]) && isset($_SESSION["email"])){
			unset($_SESSION["id"]);
			unset($_SESSION["email"]);
		}
		
		header( 'Location: login.php' );
	}
	
	//Aumento il counter dei tentativi fatti
	private function controllaTentativi(){
		if(empty($_SESSION["nTent"])){
			$_SESSION["nTent"] = 0;
		}
		
		$_SESSION["nTent"]++;
		
		if($_SESSION["nTent"] == 3){
			$_SESSION["tempoInizio"] = time();
			echo("\nTroppi tentativi, riprova tra 30 secondi");
		}
	}
	
	//metodo per stipulare un contratto
	public function stipulaContratto(){
		
		foreach($_POST as $key => $value){
			$value = $this->clean_input($value); //Sanificazione input
		}
		
		$id_cliente = $_SESSION["id"];
		$id_serv	= $this->val_input("number", $_POST["servizio"]);
		$tipo_pag	= $this->val_input("text", $_POST["tipo_pag"]);
		
		$connessione = $this->connetti();
		
		//eseguo una certa query a seconda di che dati sono arrivati
		if($tipo_pag == "Carta credito"){
			$carta_cred = $this->val_input("carta_cred", $_POST["carta_cred"]);
			$cod_cred = $this->val_input("cod_cred", $_POST["cod_cred"]);
			$data_scad = $this->val_input("date", $_POST["data_scad"]."-01");
			
			$query = 'INSERT INTO contratto (id_cliente, id_serv, tipo_pag, carta_cred, cod_cred, data_scad)';
			$query .='VALUES(:id_cliente, :id_serv, :tipo_pag, :carta_cred, :cod_cred, :data_scad)';
			
			$sql = $connessione->prepare($query);
			$sql->bindParam(":id_cliente", $id_cliente);
			$sql->bindParam(":id_serv", $id_serv);
			$sql->bindParam(":tipo_pag", $tipo_pag);
			$sql->bindParam(":carta_cred", $carta_cred);
			$sql->bindParam(":cod_cred", $cod_cred);
			$sql->bindParam(":data_scad", $data_scad);
			
			
		}else{
			$iban = $this->val_input("alphanumeric", $_POST["iban"]);
			
			$query = 'INSERT INTO contratto (id_cliente, id_serv, tipo_pag, iban)';
			$query .='VALUES(:id_cliente, :id_serv, :tipo_pag, :iban)';
			
			$sql = $connessione->prepare($query);
			$sql->bindParam(":id_cliente", $id_cliente);
			$sql->bindParam(":id_serv", $id_serv);
			$sql->bindParam(":tipo_pag", $tipo_pag);
			$sql->bindParam(":iban", $iban);
		}
		
		//inserisco i dati nel DB
		$sql->execute();
		
		echo("Contratto stipulato!");
		$this->mostraHomePage();
	}
	
	//Metodo che modifica il livello attuale di una certa cisterna
	public function modificaLivello(){
		
		foreach($_GET as $key => $value){
			$value = $this->clean_input($value); //Sanificazione input
		}
		
		$livello = $this->val_input("number", $_GET["livello"]);
		$id_cisterna = $this->val_input("number", $_GET["id_cisterna"]);
		
		$connessione = $this->connetti();
		
		$query = 'UPDATE cisterna SET livello = ' . $livello . ' WHERE id_cisterna = ' . $id_cisterna;
		
		$connessione->exec($query);
		
		echo("Dati modificati!");
	}
	
	//Metodo che crea un nuovo record con il pagamento effettuato automaticamente alla consegna
	public function effettuaConsumo(){
		
		foreach($_GET as $key => $value){
			$value = $this->clean_input($value); //Sanificazione input
		}
		
		$id_contatore = $this->val_input("number", $_GET["id_contatore"]);
		$cons_totale = $this->val_input("number", $_GET["cons_totale"]);
		$data = $this->val_input("date", $_GET["data"]);
		
		$connessione = $this->connetti();
		
		$query = 'INSERT INTO consumo (id_consumo, id_contatore, cons_totale, data)';
		$query .='VALUES(NULL,:id_contatore, :cons_totale, :data)';
		
		$sql = $connessione->prepare($query);
		$sql->bindParam(":id_contatore", $id_contatore);
		$sql->bindParam(":cons_totale", $cons_totale);
		$sql->bindParam(":data", $data);
		
		
		$connessione->exec($query);
		
		echo("Dati aggiunti!");
	}
	
	
	//Metodo per connettersi al DB
	private function connetti(){
		try{
			$host = 'mysql:dbname=elaborato_esame;host=127.0.0.1;port=3306';
			
			//Effetto la connessione
			$connection = new PDO($host, "root", "");
			
			//Setto la possibilità di vedere gli errori SQL via PHP
			$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			//Se non esistono, creo tutte le tabelle del DB
			$queryDB = ' CREATE TABLE IF NOT EXISTS societa (
						 id_societa INT(10) NOT NULL AUTO_INCREMENT ,
						 partita_iva VARCHAR(11) NOT NULL ,
						 rag_soc VARCHAR(50) NOT NULL ,
						 email VARCHAR(50) NOT NULL ,
						 cap_soc INT(15) NOT NULL ,
						 via VARCHAR(30) NOT NULL ,
						 num_civ VARCHAR(10) NOT NULL ,
						 citta VARCHAR(30) NOT NULL ,
						 comune VARCHAR(30) NOT NULL ,
						 tel VARCHAR(30) NOT NULL ,
						 PRIMARY KEY (id_societa)); 

						CREATE TABLE IF NOT EXISTS sede ( 
							id_sede INT(10) NOT NULL AUTO_INCREMENT ,
						 via VARCHAR(30) NOT NULL ,
						 num_civ VARCHAR(10) NOT NULL ,
						 comune VARCHAR(30) NOT NULL ,
						 provincia VARCHAR(30) NOT NULL ,
						 id_societa INT(10) NOT NULL ,
						 PRIMARY KEY (id_sede)); 

						CREATE TABLE IF NOT EXISTS dipendente ( 
							cod_fis VARCHAR(16) NOT NULL ,
						 nome VARCHAR(30) NOT NULL ,
						 cognome VARCHAR(30) NOT NULL ,
						 email VARCHAR(50) NOT NULL ,
						 ruolo ENUM("Amministratore","Caporeparto","Lavoratore") CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL;
						 stipendio INT(10) NOT NULL ,
						 via VARCHAR(30) NOT NULL ,
						 num_civ VARCHAR(10) NOT NULL ,
						 comune VARCHAR(30) NOT NULL ,
						 provincia VARCHAR(30) NOT NULL ,
						 iban VARCHAR(50) NOT NULL ,
						 data_nasc DATE NOT NULL ,
						 password VARCHAR(100) NOT NULL,
						 id_sede INT(10) NOT NULL ,
						 PRIMARY KEY (cod_fis)); 

						CREATE TABLE IF NOT EXISTS servizio ( 
							id_serv INT(10) NOT NULL AUTO_INCREMENT ,
						 tipo VARCHAR(30) NOT NULL ,
						 costo_fisso FLOAT(10) NOT NULL ,
						 costo_unit FLOAT(10) NOT NULL ,
						 PRIMARY KEY (id_serv)); 

						CREATE TABLE IF NOT EXISTS contatore ( 
							id_contatore INT(10) NOT NULL AUTO_INCREMENT ,
						 via VARCHAR(30) NOT NULL ,
						 num_civ VARCHAR(10) NOT NULL ,
						 comune VARCHAR(30) NOT NULL ,
						 provincia VARCHAR(30) NOT NULL ,
						 PRIMARY KEY (id_contatore)); 

						CREATE TABLE IF NOT EXISTS sede_servizio ( 
						 id_sede INT(10) NOT NULL ,
						 id_serv INT(10) NOT NULL ,
						 PRIMARY KEY( id_sede, id_serv)); 

						CREATE TABLE IF NOT EXISTS cliente (
							id_cliente INT(10) NOT NULL AUTO_INCREMENT, 
						 cod_fis VARCHAR(16) NOT NULL,
						 nome VARCHAR(30) NOT NULL ,
						 cognome VARCHAR(30) NOT NULL ,
						 email VARCHAR(50) NOT NULL ,
						 telefono VARCHAR(30) NOT NULL ,
						 via VARCHAR(30) NOT NULL ,
						 num_civ VARCHAR(10) NOT NULL ,
						 comune VARCHAR(30) NOT NULL ,
						 provincia VARCHAR(30) NOT NULL ,
						 data_nasc DATE NOT NULL ,
						 password VARCHAR(100) NOT NULL,
						 PRIMARY KEY (id_cliente)); 

						CREATE TABLE IF NOT EXISTS consumo ( 
							id_consumo INT(10) NOT NULL AUTO_INCREMENT ,
						 cons_totale FLOAT(10) NOT NULL ,
						 data DATE NOT NULL ,
						 id_contatore INT(10) NOT NULL,
						 PRIMARY KEY (id_consumo));

						CREATE TABLE IF NOT EXISTS contratto ( 
							id_contratto INT(10) NOT NULL AUTO_INCREMENT,
							id_cliente INT(10) NOT NULL
							id_contatore INT(10) NULL , 
							id_serv INT(10) NOT NULL ,
							id_cisterna INT(10) NULL ,  
							tipo_pag ENUM("Carta credito","Conto corrente") NOT NULL , 
							IBAN VARCHAR(50) NULL DEFAULT NULL , 
							carta_cred VARCHAR(16) NULL DEFAULT NULL , 
							cod_cred VARCHAR(3) NULL DEFAULT NULL , 
							data_scad DATE NULL DEFAULT NULL ,
							PRIMARY KEY(id_contratto));

						CREATE TABLE IF NOT EXISTS cisterna (
							id_cisterna INT(10) NOT NULL,
							livello FLOAT(10) NOT NULL,
							capacita FLOAT(10) NOT NULL,
							via VARCHAR(30) NOT NULL,
							num_civ VARCHAR(10) NOT NULL, 
							comune VARCHAR(30) NOT NULL,
							provincia VARCHAR(30) NOT NULL,
							PRIMARY KEY(id_cisterna)
						);
						
						CREATE TABLE IF NOT EXISTS richiesta (
							id_richiesta INT(10) NOT NULL,
							via VARCHAR(30) NOT NULL,
							num_civ VARCHAR(10) NOT NULL,
							comune VARCHAR(30) NOT NULL,
							provincia VARCHAR(30) NOT NULL,
							data DATE NOT NULL,
							effettuato BOOLEAN NOT NULL,
							id_cliente INT(10) NOT NULL,
							id_serv INT(10) NOT NULL,
							PRIMARY KEY(id_richiesta)
						);

						ALTER TABLE contatore ADD CONSTRAINT "È posseduto da" FOREIGN KEY (id_cliente) REFERENCES cliente(id_cliente) ON DELETE CASCADE ON UPDATE CASCADE; 


						ALTER TABLE dipendente ADD CONSTRAINT "Lavora in" FOREIGN KEY (id_sede) REFERENCES sede(id_sede) ON DELETE CASCADE ON UPDATE CASCADE; 

						ALTER TABLE sede ADD CONSTRAINT "Appartiene a" FOREIGN KEY (id_societa) REFERENCES societa(id_societa) ON DELETE CASCADE ON UPDATE CASCADE; 

						ALTER TABLE sede_servizio ADD CONSTRAINT "Foreign_sede" FOREIGN KEY (id_sede) REFERENCES sede(id_sede) ON DELETE CASCADE ON UPDATE CASCADE; 
						ALTER TABLE sede_servizio ADD CONSTRAINT "Foreign_servizio" FOREIGN KEY (id_serv) REFERENCES servizio(id_serv) ON DELETE CASCADE ON UPDATE CASCADE; 

						ALTER TABLE consumo ADD CONSTRAINT "È misurato da" FOREIGN KEY (id_contatore) REFERENCES contatore(id_contatore) ON DELETE CASCADE ON UPDATE CASCADE;

						ALTER TABLE contratto ADD CONSTRAINT "Stipula" FOREIGN KEY (id_cliente) REFERENCES cliente(id_cliente) ON DELETE CASCADE ON UPDATE CASCADE;
						ALTER TABLE contratto ADD CONSTRAINT "Viene collegato" FOREIGN KEY (id_contatore) REFERENCES contatore(id_contatore) ON DELETE CASCADE ON UPDATE CASCADE; 
						ALTER TABLE contratto ADD CONSTRAINT "Fornisce" FOREIGN KEY (id_serv) REFERENCES servizio(id_serv) ON DELETE CASCADE ON UPDATE CASCADE;
						ALTER TABLE contratto ADD CONSTRAINT "Viene collegato 2" FOREIGN KEY (id_cisterna) REFERENCES cisterna(id_cisterna) ON DELETE CASCADE ON UPDATE CASCADE;
						
						ALTER TABLE richiesta ADD CONSTRAINT "Richiede" FOREIGN KEY (id_serv) REFERENCES servizio(id_serv) ON DELETE CASCADE ON UPDATE CASCADE; 
						ALTER TABLE richiesta ADD CONSTRAINT "È richiesto" da FOREIGN KEY (id_cliente) REFERENCES cliente(id_cliente) ON DELETE CASCADE ON UPDATE CASCADE;';
			$connection->exec($queryDB);
		}catch(PDOException $e){
			//Se ci sono eccezioni, mostro il messaggio d'errore
			echo("Connection error: ".$e->getMessage());
		}
		//echo("Connessione effettuata!");

		return $connection;
	}
}
