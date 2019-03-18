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

    /*  Controllo che i campi username e password siano stati compilati */

    if(!isset( $_POST['username'], $_POST['password'])) {

      $message = 'I campi password e username devono essere compilati<br>';
    }


    elseif (strlen( $_POST['username']) > 50 || strlen($_POST['username']) < 0){

      $message =  $message . 'La lunghezza del nome utente non è corretta<br>';
    }

    elseif (strlen( $_POST['password']) > 100 || strlen($_POST['password']) < 0){

      $message = 'La lunghezza della password non è corretta<br>';
    }

    elseif (ctype_alnum($_POST['username']) != true){

    $message = "Il nome utente dev'essere alfanumerico<br>";

    }

    elseif (ctype_alnum($_POST['password']) != true){

        $message = "La password deve essere alfanumerica<br>";

    }

    else {

    /*  Se i dati inseriti sono corretti "sanizziamo" il formato della variabile
        (abbastanza inutile a mio avviso, ma mi attengo all'esercizio)
    */

    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
    $email = $_POST['email'];

    /*  Crittografiamo la password  */
    $password = sha1( $password );

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
        }
        else{

            $message = 'Non riusciamo a soddisfare la richiesta in questo momento<br>';
        }
    }
}

?>

		<?php if(! isset( $_SESSION['user_id'] ) ): ?>

  	<nav class="navbar my_navbar sticky-top  navbar-expand-lg navbar-dark bg-dark">
		  <a class="navbar-brand site_title" href="index.php">Home</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
		  		<span class="navbar-toggler-icon"></span>
		  	</button>
		  <div class="collapse navbar-collapse" id="navbarNavDropdown">
		    <ul class="navbar-nav">
			    <li class="nav-item">
			   		<button  onclick="window.location.href='sign_in.php'" class="login my_menu-button btn btn-outline-success" type="button">
			   			Login
			   		</button>
			    </li>
				</ul>
			</div>
		</nav>

    <?php echo "<h1 class=\"homepage_user_message\">$message</h1>"; ?>

</div>



		<?php else: ?>

      <nav class="navbar my_navbar sticky-top  navbar-expand-lg navbar-dark bg-dark">
  		  <a class="navbar-brand site_title" href="index.php">Home</a>
  				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
  		  		<span class="navbar-toggler-icon"></span>
  		  	</button>
  		  <div class="collapse navbar-collapse" id="navbarNavDropdown">
  		    <ul class="navbar-nav">
  			    <li class="nav-item">
  			   		<button  onclick="window.location.href='sign_in.php'" class="login my_menu-button btn btn-outline-success" type="button">
  			   			Esci
  			   		</button>
  			    </li>
  				</ul>
  			</div>
  		</nav>

      <?php echo "<h1 class=\"homepage_user_message\">Benvenuto $username!</h1>"; ?>

		<?php endif; ?>

	</body>
</html>
