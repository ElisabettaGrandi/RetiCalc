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
        <div id='sottotitolo' class='center'> Crea Richiesta </div>
        <br>   
    <?php
    if(isset($_SESSION['username'])){
        if(isset($_POST['selCategoria'])){
            $sql = "SELECT tCategoria.nome FROM tCategoria WHERE idCategoria = ".$_POST['selCategoria'];
            $result = $conn->query($sql);
            if ($result->num_rows == 0) {
                $res = "Nessun dato in tabella";
                }
            else {
                while($row = $result->fetch_assoc()){
                    echo "<div id='sottotitolo'> Risultati caregoria: ".$row['nome']."</div>";
                }
            }

            $sql = "SELECT tCapacita.id AS idCapacita, tAbilita.nome AS nomeAbilita, tCapacita.userAssociato, tAbilita.oreStimate, tZona.nome AS nomeZona
            FROM tAbilita 
            INNER JOIN tCapacita ON tAbilita.idAbilita=tCapacita.idAbilita 
            INNER JOIN tAssociato ON tAssociato.username=tCapacita.userAssociato 
            INNER JOIN tZona ON tAssociato.idZona=tZona.idZona 
            WHERE tAbilita.idCategoria = ".$_POST['selCategoria'] ." AND NOT tAssociato.username = '".$_SESSION['username']."' ";
            $result = $conn->query($sql);
            if ($result->num_rows == 0) {
                $res = "Nessun dato in tabella";
                echo "<div id='testo'> Non sono presenti prestazioni disponibili da altri utenti! </div>";
                }
            else {
                while($row = $result->fetch_assoc()){
                    echo "<div id='elemento'>";
                    echo "<div id='testo2Bold'> ".$row['nomeAbilita']." </div><br>";
                    echo "<div id='testo2'> Associato offerente: <br> ".$row['userAssociato']." </div>";
                    echo "<div id='testo2'> Ore stimate richieste: <br> ".$row['oreStimate']." </div>";
                    echo "<div id='testo2'> Zona del servizio: <br> ".$row['nomeZona']." </div><br>";
                    echo "<input type='button' id='bottoneSel' name='btnRichiesta' value='Richiedi' onClick='goRichiesta(".$row['idCapacita'].")'>";
                    echo "</div>";
                }
            }
        }
        else {
            if(isset($_GET['idC'])) {
                $sql = "INSERT INTO tRichiesta (data, userRichiedente, idCapacita) VALUES ('".date('Y-m-d')."', '".$_SESSION['username']."', ".$_GET['idC'].")";
                $result = $conn->query($sql);
                echo "<script> alert('Richiesta inviata con successo! Ora puoi attendere che venga svolto il lavoro!'); window.location.href = 'index.php' </script>";
            }
            else {
                echo "<div class='centro' id='testo2'>";
                echo "<form method='POST' action='richiesta.php' onSubmit=''>";
                echo "Seleziona categoria <br> <select name='selCategoria' id='selCategoria'> 
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
                echo "<input type='submit' id='bottone' name='btnCerca' value='Cerca Prestazione'> <br><br>";
                echo "</div>";
            }
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

</html>