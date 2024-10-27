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
		<div id='sottotitolo' class='center'> Associati in debito </div>
		<br>
    <?php
    if(isset($_SESSION['username'])){
        echo "<table style=\"margin-left: auto; margin-right: auto\">
        <tbody>";
        echo "<tr><th> Associato </th><th> Debito </th></tr>";
        $sqlAssociati = "SELECT tAssociato.username FROM tAssociato";
        $resultAssociati = $conn->query($sqlAssociati);
        if($resultAssociati->num_rows == 0){

        }
        else {
            while($rowAssociati = $resultAssociati->fetch_assoc()) {
                $sqlRichiesta = "SELECT SUM(tprestazione.ore) AS oreTotaliRichieste
                FROM trichiesta
                LEFT OUTER JOIN tprestazione ON tprestazione.idRichiesta=trichiesta.idRichiesta
                WHERE trichiesta.userRichiedente='".$rowAssociati['username']."'";
                $resultRichiesta = $conn->query($sqlRichiesta);
                if ($resultRichiesta->num_rows == 0) {
                    $res = "Nessun dato in tabella";
                    }
                else {
                    while($rowRichiesta = $resultRichiesta->fetch_assoc()){
                        if($rowRichiesta['oreTotaliRichieste']==NULL){
                            $richieste=0;
                        }
                        else{
                            $richieste=$rowRichiesta['oreTotaliRichieste'];
                        }
                    }
                }
                $sqlServite = " SELECT SUM(tprestazione.ore) AS oreServiteTotali
                FROM trichiesta
                LEFT OUTER JOIN tprestazione ON tprestazione.idRichiesta=trichiesta.idRichiesta
                INNER JOIN tcapacita ON tcapacita.id=trichiesta.idCapacita
                WHERE tcapacita.userAssociato='".$rowAssociati['username']."'";
                $resultServite = $conn->query($sqlServite);
                if ($resultServite->num_rows == 0) {
                    $res = "Nessun dato in tabella";
                    }
                else {
                    while($rowServite = $resultServite->fetch_assoc()){
                        if($rowServite['oreServiteTotali']==NULL){
                            $servite=0;
                        }
                        else{                            
                            $servite = $rowServite['oreServiteTotali'];
                        }
                    }
                }
                $disponibili = $servite-$richieste;
                if($disponibili<0)
                    echo "<tr><td> ".$rowAssociati['username']." </td><td> ".$disponibili." </td></tr>";
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