<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
	<head>
		<title>Login</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script src="scripts/jquery-3.5.1.min.js"> </script>
        <script src="scripts/bootstrap.js" ></script>
        <link rel="stylesheet" type="text/css" href="style/bootstrap.css"/>
		<script src="scripts/script.js"></script>
	</head>
	<body>
		<form class="container-md" id="login" action='effettuaLogin.php' method='POST' onSubmit="return validate_form(this)">
			<div class="row">
				<div class="col-3"> <label for="email"> Email: </label> </div>
				<div class="col-3"> <input required value="<?php $strEmail=isset($_COOKIE['email']) ? $_COOKIE['email'] : ""; echo($strEmail);  ?>" id="email" name="email" type="email" /> </div>
			</div>
			<div class="row">
				<div class="col-3"> <label for="password"> Password: </label> </div>
				<div class="col-3"> <input required id="password" name="password" type="password"/> </div>
			</div>
			<div class="row">
				<div class="col-2"> <input name="ricordami" id="ricordami" type="checkbox" <?php if(isset($_COOKIE['email'])) echo("checked"); ?>/> <label for="ricordami"> Ricordami </label> </div>
			</div>
			<div class='row'>
				<div class='col-2'> <input type='submit' value='Effettua login' name='submit'> </div>
			</div>
		</form>
		<div class="container-md">
			<div class="row">
				<div class='col-3'> <button onclick="openPage('mostraRegistrazione.php')"> Non ancora registrato? </button>  </div>
			</div>
		</div>
		<div class="container-md" style="color: #FF0000">
			<?php
				session_start();
				if (isset($_SESSION['message']))
					{
						echo $_SESSION['message'];
						unset($_SESSION['message']);
					}  ?>
		</div>
	</body>
</html>
