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

    /*  Inizio sessione */
    session_start();

		/*  Non è necessario alcun tipo di controllo, dato che tutto viene controllato
				dal client mediante uno script
    */



		if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email'])){

	    $username = $_POST['username'];
	    $password = $_POST['password'];
	    $email = $_POST['email'];

			/*  Crittografiamo la password  */
	    $password = sha1( $password );
			$is_ok = true;

		}else{

			$message = "Errore durante la ricezione dei dati";
			$is_ok = false;
		}



	   $tipo = "N";

    /*** connect to database ***/
    /*** mysql hostname ***/
    $mysql_hostname = 'localhost';

    /*** mysql username ***/
    $mysql_username = 'root';

    /*** mysql password ***/
    $mysql_password = '';

    /*** database name ***/
    $mysql_dbname = 'esercitazione_accesso_db';

		if ($is_ok){

	    try{

	        $dbh = new PDO("mysql:host=$mysql_hostname;dbname=$mysql_dbname", $mysql_username, $mysql_password);

	        /*  Intercettiamo eventuali errori di connessione */
	        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	        /*  Prepariamo l'inserimento dei dati all'interno del database  */
	        $stmt = $dbh->prepare("INSERT INTO utenti (nome_utente, password, email) VALUES (:username, :password, :email )");

	        /*  Associamo le 'etichette' usate nella quary alle rispettive variabili */
	        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
	        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
			    $stmt->bindParam(':email', $email, PDO::PARAM_STR);

	        /*  Eseguiamo la query  */
	        $stmt->execute();

	        $message = 'Utente aggiunto correttamente<br>';


	        $_SESSION['user_id'] = $username;

	    /*  Intercettiamo eventuali errori  */
	    }catch(Exception $e){

	        /*  Controlliamo che l'username non sia già presente  */

	        if( $e->getCode() == 23000){
	            $message = 'L\'username esiste già<br>';
	        }else{
	            $message = 'Non riusciamo a soddisfare la richiesta in questo momento<br>';
	        }

					$is_ok = false;
	    }

		}

?>

      <nav class="navbar my_navbar sticky-top  navbar-expand-lg navbar-dark bg-dark">
  		  <a class="navbar-brand site_title" href="index.php">Home</a>
  		</nav>

			<?php

					if ($is_ok){
						echo $message . $user;
					}else{
						echo $message;
					}


			 ?>


	</body>
</html>
