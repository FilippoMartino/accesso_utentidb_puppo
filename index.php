<!DOCTYPE html>
<html>
	<head>
		<title>Esercizio accessi a database</title>

		<!-- Link al mio foglio di stile -->
		<link rel="stylesheet" href="my_personal_css.css">

		<!-- Link alle cdn di bootstrap css, js e jquery-->

		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

		<link href="https://fonts.googleapis.com/css?family=Dosis:300|Raleway:300" rel="stylesheet"> 	

		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

	</head>
	<body>
		<?php 

			// hostname
			$hostname = "localhost";
			// utente per la connessione a MySQL
			$username = "filippo.martino";
			// password per l'autenticazione dell'utente
			$password = "password";
			// connessione tramite mysql_connect()
			$connessione = mysql_connect($hostname, $username, $password);
			
			// variabile per controllare che l'utente non si sia già autenticato

			$login = false;

			echo   '<nav class="navbar my_navbar sticky-top  navbar-expand-lg navbar-dark bg-dark">
					  <a class="navbar-brand site_title" href="#">Home</a>
					 	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
					   	 <span class="navbar-toggler-icon"></span>
					  	</button>
					    <div class="collapse navbar-collapse" id="navbarNavDropdown">
						    <ul class="navbar-nav">
							    <li class="nav-item">
							   		<button class="login my_menu-button btn btn-outline-success" type="button">
							   			Login
							   		</button>
							    </li>
							    <li class="nav-item">
							        <button class="btn btn-outline-success my_menu-button sign-in" type="button">
							   			Sign in
							   		</button>
							    </li>
							</ul>
						</div>
					</nav>';

			$nome = "Filippo";

			if ($login){

				echo '<div class="homepage_user_message">Bentornato' . " $nome" . '</div>';
					
			}else {

				echo '<div class="homepage_user_message">Non hai ancora effettuato il login</div>';

			}


			


		 ?>



	</body>
</html>