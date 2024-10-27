<?php
	require "config.php";
	session_start();
?>
<html>
	<head>
		<title>BancaTempo</title>
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lobster">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Comfortaa">
		<link rel="stylesheet" type="text/css" href="stile.css" />
		<script src="script.js" language="javascript">	</script>
	</head>
	<body>		
	<div id="menuLeft">
		<br><br>
		<div id="testoLeft">
			<a href="index.php" class = "testoLinkMenuLeft"> Homepage </a>
		</div>
	</div>
	<div id="corpo">
		<div id="titolo"> 
			<a id="testoTitolo" class="centroVert"> Banca del Tempo </a>
		</div>
		<br><br>
		<div id='sottotitolo' class='center'> ACCEDI </div>
		<br>
		<?php
		if(isset($_POST['txtUserLogin'])){
			$sql = "SELECT * FROM tAssociato WHERE username='".$_POST['txtUserLogin']."' AND password='".$_POST['txtPassLogin']."'";
			$result = $conn->query($sql);
			if ($result->num_rows == 0) {
				$res = "Nessun dato in tabella";
				echo "<script> alert('Credenziali errate'); window.location.href = 'login.php'; </script>";
			}
			else {
				while($row = $result->fetch_assoc()) {
					$_SESSION['username'] = $row['username'];
					echo "<script> alert('Login eseguito con successo!'); window.location.href = 'index.php' </script>";
				}
			}
		} 
		else {
			echo "<div class='centro' id='testo2'>";
			echo "<form method='POST' action='login.php' onSubmit='return controllaLogin()'>";
			echo "Username <br> <input type='text' id='txtUserLogin' name='txtUserLogin'> <br><br>";
			echo "Password <br> <input type='password' id='txtPassLogin' name='txtPassLogin'> <br><br>";
			echo "<input type='submit' id='bottone' name='btnLogin' value='Login'> <br><br>";
			echo "<a href='registrazione.php' class='testolink' > Non sei ancora registrato? Clicca qui </a>";
			echo "</div>";
		}
		?>
	</div>
  	</body>

</html>