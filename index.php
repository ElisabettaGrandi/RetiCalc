<?php
	require "config.php";
	session_start();
?>
<head>
		<title>BancaTempo</title>
	<link rel="stylesheet" type="text/css" href="stile.css" />
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lobster">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Comfortaa">
	<script src="script.js" language="javascript">	</script>
</head>
<body>	
	<div id="menuLeft">
		<div id="login" class="centroVert"> 
		<?php
			if(isset($_SESSION['username'])){
				echo "<div id='testoLogin' >";
				echo $_SESSION['username']."<br>";
				echo "<br><a href='riepilogo.php' class='testoLinkMenuLeft'> Gestione Ore </a><br>";
				echo "<br><a href='account.php' class='testoLinkMenuLeft'> Gestione Abiliità </a><br>";
				echo "<br><a href='ricevute.php' class='testoLinkMenuLeft'> Richieste Ricevute </a><br>";
				echo "<br><a href='login.php' class='testoLinkMenuLeft'> Cambia Account </a><br>";
				echo "</div>";

			}
			else
				echo"<input type='button' id='bottoneLogin' name='btnGoLogin' value='Login' onClick='goLogin()'>";
		?>
		</div>
		<div id="testoLeft">
			<a href="index.php" class = "testoLinkMenuLeft"> Homepage </a>
			<br><br><a href="richiesta.php" class="testoLinkMenuLeft"> Crea Richiesta </a>
			<br><br><br>
			<a> Funzioni Disponibili: </a> <br><br>
			<a href="debito.php" class = "testoLinkMenuLeft"> Associati in debito </a><br><br>
			<a href="zona_prestazione.php" class = "testoLinkMenuLeft"> Prestazioni nella tua zona </a><br><br>
			<a href="segreteria.php" class = "testoLinkMenuLeft"> Associati Tuttofare </a><br><br>
			<a href="elenco_prestazioni.php" class = "testoLinkMenuLeft"> Elenco Prestazioni </a><br><br>
		</div>
	</div>
	
	<div id="corpo">	
	<div id="titolo"> 
		<a id="testoTitolo" class="centroVert"> Banca del Tempo </a>
	</div>	
		<br><br>
		<iframe height="40%" width="50%"
		src="https://youtube.com/embed/N6vWgga3I7Q?autoplay=1&t=7s">
		</iframe>
	</div>
	
</body>