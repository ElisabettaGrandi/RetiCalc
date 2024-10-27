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
		<div id='sottotitolo' class='center'> Elenco Prestazioni </div>
		<br>
    <?php
    if(isset($_SESSION['username'])) {
        echo "<div class='centro' id='testo'>";
        echo "Elenco delle prestazioni ordinate per ore servite";
        echo "</div><br>";
        echo "<table style=\"margin-left: auto; margin-right: auto\">
        <tbody>";
        echo "<tr><th> User Richiedente </th><th> User Erogatore </th><th> Abilità Richiesta </th><th> Data Richiesta </th><th> Data Prestazione </th><th> Ore Utilizzate </th></tr>";
		$sql = "SELECT trichiesta.userRichiedente AS richiedente, tcapacita.userAssociato AS erogatore, trichiesta.data AS dataRichiesta, tprestazione.data AS dataPrestazione, tprestazione.ore AS oreRichieste, tabilita.nome AS abilità
        FROM tprestazione
        INNER JOIN trichiesta ON trichiesta.idRichiesta = tprestazione.idRichiesta
        INNER JOIN tcapacita ON tcapacita.id=trichiesta.idCapacita
        INNER JOIN tabilita ON tabilita.idAbilita=tcapacita.idAbilita
        ORDER BY oreRichieste DESC";
        $result = $conn->query($sql);
        if ($result->num_rows == 0) {
            $res = "Nessun dato in tabella";
            }
        else {
            while($row = $result->fetch_assoc()){
                echo "<tr><td> ".$row['richiedente']." </td><td> ".$row['erogatore']." </td><td> ".$row['abilità']." </td><td> ".$row['dataRichiesta']." </td><td> ".$row['dataPrestazione']." </td><td> ".$row['oreRichieste']." </td></tr>";
            }
        }
        echo "</tbody>
        </table>";
    }
    else {
		echo "<div class='centro' id='testo'>";
        echo "Devi fare prima il login!";
		echo "</div><br>";
    }

    

    
    ?>
	</div>
	
</body>