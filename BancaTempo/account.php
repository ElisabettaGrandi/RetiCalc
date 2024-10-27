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
			<br><br><a href="inserimento.php" class="testoLinkMenuLeft"> Crea Richiesta </a>
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
		<div id='sottotitolo' class='center'> Aggiungi abilità </div>
		<br>
		<?php
		echo "<div class='centro' id='testo'>";
		echo "Le abilità di ".$_SESSION['username'];
		echo "</div><br>";
		echo "<div class='centro' id='testo2'>";
		$sql = "SELECT tabilita.nome FROM tabilita INNER JOIN tcapacita ON tabilita.idAbilita = tcapacita.idAbilita WHERE userAssociato = '".$_SESSION['username']."'";
		$result = $conn->query($sql);
		if ($result->num_rows == 0) {
			$res = "Nessun dato in tabella";
			}
		else {
			while($row = $result->fetch_assoc()){
				echo $row['nome']." <br> ";
			}
		}
		echo "</div><br><br>";

		if(isset($_GET['add'])){
			if(isset($_POST['txtAbilitaNuova'])){
				$sql = "INSERT INTO tAbilita (nome, oreStimate, idCategoria) VALUES ('".$_POST['txtAbilitaNuova']."', ".$_POST['txtOreStimate'].", ".$_POST['selCategoria'].")";
				$result = $conn->query($sql);
				echo "<script> alert('Abilità inserita con successo'); window.location.href = 'account.php' </script>";
			} 
			else {
				echo "<div class='centro' id='testo2'>";
				echo "<form method='POST' action='account.php?add=1' onSubmit=''>";
				echo "Nome abilità <br> <input type='text' id='txtAbilitaNuova' name='txtAbilitaNuova'> <br><br>";
				echo "Ore stimate <br> <input type='text' id='txtOreStimate' name='txtOreStimate'> <br><br>";
				echo "Categoria <br> <select name='selCategoria' id='selCategoria'> 
					<option value='' selected disabled hidden>Seleziona Categoria</option> ";
				$sql = "SELECT idCategoria, nome FROM tCategoria";
				$result = $conn->query($sql);
				if ($result->num_rows == 0) {
					$res = "Nessun dato in tabella";
					}
				else {
					while($row = $result->fetch_assoc()){
						echo "<option value='".$row['idCategoria']."'>".$row['nome']."</option>";
					}
				}
				echo "</select><br><br>";
				echo "<a href='account.php?cat=1' class='testolink' > Non è presente la categoria adatta? Clicca qui! </a><br><br>";
				echo "<input type='submit' id='bottone' name='btnAggiungi' value='Aggiungi'> <br><br>";
				echo "</div>";
			}
		}
		else {
			if(isset($_GET['cat'])){
				if(isset($_POST['txtCatNuova'])){
					$sql = "INSERT INTO tCategoria (nome) VALUES ('".$_POST['txtCatNuova']."')";
					$result = $conn->query($sql);
					echo "<script> alert('Categoria inserita con successo'); window.location.href = 'account.php?add=1' </script>";
				} 
				else {
					echo "<div class='centro' id='testo2'>";
					echo "<form method='POST' action='account.php?cat=1' onSubmit=''>";
					echo "Nome categoria <br> <input type='text' id='txtCatNuova' name='txtCatNuova'> <br><br>";
					echo "<input type='submit' id='bottone' name='btnAggiungi' value='Aggiungi'> <br><br>";
					echo "</div>";
				}
			}
			else {
				if(isset($_POST['selAbilita'])){
					$sql = "INSERT INTO tCapacita (userAssociato, idAbilita) VALUES ('".$_SESSION['username']."', ".$_POST['selAbilita'].")";
					$result = $conn->query($sql);
					echo "<script> alert('Abilità inserita con successo'); window.location.href = 'account.php' </script>";
				} 
				else {
					echo "<div class='centro' id='testo2'>";
					echo "<form method='POST' action='account.php' onSubmit=''>";
					echo "Abilità <br> <select name='selAbilita' id='selAbilita'> 
						<option value='' selected disabled hidden>Seleziona Abilità</option> ";
					$sql = "SELECT idAbilita, nome FROM tAbilita";
					$result = $conn->query($sql);
					if ($result->num_rows == 0) {
						$res = "Nessun dato in tabella";
						}
					else {
						while($row = $result->fetch_assoc()){
							echo "<option value='".$row['idAbilita']."'>".$row['nome']."</option>";
						}
					}
					echo "</select><br><br>";
					echo "<a href='account.php?add=1' class='testolink' > Non è presente la tua abilità? Clicca qui! </a><br><br>";
					echo "<input type='submit' id='bottone' name='btnAggiungi' value='Aggiungi'> <br><br>";
					echo "</div>";
				}
			}
		}
		?>
	</div>
  	</body>

</html>