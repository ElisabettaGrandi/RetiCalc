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
		<div id='sottotitolo' class='center'> Prestazioni nella tua zona </div>
		<br>
    <?php
    if(isset($_SESSION['username'])){
        if(isset($_POST['selPrestazione'])){
            $sqlZona = "SELECT tzona.idZona, tzona.nome AS nomeZona FROM tAssociato INNER JOIN tZona ON tZona.idZona = tAssociato.idZona WHERE username = '".$_SESSION['username']."'";
            $resultZona = $conn->query($sqlZona);
            if ($resultZona->num_rows == 0) {
                $res = "Nessun dato in tabella";
                }
            else {
                while($rowZona = $resultZona->fetch_assoc()){
                    $zonaAss = $rowZona['idZona'];
                    $nomeZona = $rowZona['nomeZona'];
                }
            }

            $sqlAbilita = "SELECT tabilita.nome
            FROM tabilita
            INNER JOIN tcapacita ON tcapacita.idAbilita = tabilita.idAbilita
            INNER JOIN tassociato ON tassociato.username = tcapacita.userAssociato
            WHERE tassociato.idZona = ".$zonaAss." AND tabilita.idAbilita = ".$_POST['selPrestazione']." LIMIT 1";
            $resultAbilita = $conn->query($sqlAbilita);
            if ($resultAbilita->num_rows == 0) {
                $res = "Nessun dato in tabella";
                }
            else {
                while($rowAbilita = $resultAbilita->fetch_assoc()){
                    echo "<div class='centro' id='testo'>";
                    echo $rowAbilita['nome']." a ".$nomeZona;
                    echo "</div><br>";
                }
            }

            echo "<table style=\"margin-left: auto; margin-right: auto\">
            <tbody>";
            echo "<tr><th> Username Associato </th></tr>";
            $sqlPrest = "SELECT tassociato.username
            FROM tabilita
            INNER JOIN tcapacita ON tcapacita.idAbilita = tabilita.idAbilita
            INNER JOIN tassociato ON tassociato.username = tcapacita.userAssociato
            WHERE tassociato.idZona = ".$zonaAss." AND tabilita.idAbilita = ".$_POST['selPrestazione']." AND NOT tAssociato.username = '".$_SESSION['username']."'";
            $resultPrest = $conn->query($sqlPrest);
            if ($resultPrest->num_rows == 0) {
                $res = "Nessun dato in tabella";
                }
            else {
                while($rowPrest = $resultPrest->fetch_assoc()){
                    echo "<tr><td> ".$rowPrest['username']." </td></tr>";
                }
            }
            echo "</tbody>
            </table>";
            
            echo "<div id='testo'>";
            echo "<br><a href='zona_prestazione.php' class='testolink'> Visualizza un'altra prestazione nella tua zona </a> ";
            echo "</div>";
        }
        else {
            echo "<div class='centro' id='testo2'>";
            echo "<form method='POST' action='zona_prestazione.php' onSubmit=''>";
            echo "Seleziona prestazione <br> <select name='selPrestazione' id='selPrestazione'> 
                <option value='' selected disabled hidden>Seleziona Prestazione</option> ";
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
            echo "<input type='submit' id='bottone' name='btnSelPrest' value='Cerca Prestazione'> <br><br>";
            echo "</div>";
        }
    }
    else {
		echo "<div class='centro' id='testo'>";
        echo "Devi fare prima il login!";
		echo "</div><br>";
    }
    ?>
	</div>
	
</body>