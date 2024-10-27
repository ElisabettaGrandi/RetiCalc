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
    <br>       
    <?php
    echo "<div id='sottotitolo'> Richieste di aiuto ricevute </div>";

    if(isset($_POST['txtOre'])) {
        $sql = "INSERT INTO tPrestazione (data, ore, idRichiesta) VALUES ('".$_POST['dataServizio']."', ".$_POST['txtOre'].", ".$_GET['idR'].")";
        $result = $conn->query($sql);
        echo "<script> alert('Prestazione confermata! Le ore in cui hai lavorato saranno aggiunte alle tue ore disponibili!'); window.location.href = 'index.php' </script>";
    }
    else {
        if(isset($_GET['idR'])) {
            echo "<div class='centro' id='testo2'>";
            echo "<form method='POST' action='ricevute.php?idR=".$_GET['idR']."' onSubmit=''>";
            echo "Ore Servite <br> <input type='text' id='txtOre' name='txtOre'> <br><br>";
            echo "Data Servizio <br> <input type='date' id='dataServizio' name='dataServizio'> <br><br>";
            echo "<input type='submit' id='bottone' name='btnLogin' value='Conferma Servizio Prestato'> <br><br>";
            echo "</div>";
        }
        else {
            $sql = "SELECT tRichiesta.userRichiedente, tAbilita.nome AS nomeAbilita, tRichiesta.idRichiesta 
            FROM tRichiesta 
            INNER JOIN tCapacita ON tCapacita.id=tRichiesta.idCapacita 
            INNER JOIN tAbilita ON tCapacita.idAbilita=tAbilita.idAbilita 
            WHERE tCapacita.userAssociato='".$_SESSION['username']."' AND tRichiesta.idRichiesta NOT IN (SELECT idRichiesta FROM tPrestazione)";
            $result = $conn->query($sql);
            if ($result->num_rows == 0) {
                $res = "Nessun dato in tabella";
                echo "<div id='testo'> Non sono presenti richieste da altri utenti! </div>";
                }
            else {
                while($row = $result->fetch_assoc()){
                    echo "<div id='elemento'>";
                    echo "<div id='testo2Bold'> ".$row['nomeAbilita']." </div><br>";
                    echo "<div id='testo2'> Associato richiedente: <br> ".$row['userRichiedente']." </div><br>";
                    echo "<input type='button' id='bottoneSel' name='btnEseguita' value='Completa' onClick='goCompleta(".$row['idRichiesta'].")'>";
                    echo "</div>";
                }
            }
        }
    }    
    ?>
    </div>
  </body>

</html>