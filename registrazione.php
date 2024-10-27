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
        <br>
        <br>
        <div id='sottotitolo'> REGISTRAZIONE </div>
        <?php
        if(isset($_POST['txtUserReg'])){
            $sql = "SELECT * FROM tAssociato WHERE username='".$_POST['txtUserReg']."'";
            $result = $conn->query($sql);
            if ($result->num_rows == 0) {
                $res = "Nessun dato in tabella";
                $sql2 = "INSERT INTO tAssociato VALUES ('".$_POST['txtUserReg']."', '".$_POST['txtNomeReg']."', '".$_POST['txtCognReg']."','".$_POST['txtPassReg']."', ".$_POST['selZona'].")";
                $result2 = $conn->query($sql2);
                $_SESSION['username'] = $_POST['txtUserReg'];
                echo "<script> alert('Registrazione avvenuta con successo'); window.location.href = 'index.php';</script>";
        
            }
            else {
                while($row = $result->fetch_assoc()) {
                    echo "<script> alert('Username già in uso'); window.location.href = 'registrazione.php'; </script>";
                }
            }
        }
        else {
            echo "<div class='centro' id='testo2'>";
            echo "<form method='POST' action='registrazione.php' onSubmit='return controllaReg()'>";
            echo "Username <br> <input type='text' id='txtUserReg' name='txtUserReg'> <br><br>";
            echo "Nome <br> <input type='text' id='txtNomeReg' name='txtNomeReg'> <br><br>";
            echo "Cognome <br> <input type='text' id='txtCognReg' name='txtCognReg'> <br><br>";
			echo "Zona <br> <select name='selZona' id='selZona'> 
                <option value='' selected disabled hidden>Seleziona Zona</option> ";
            $sql = "SELECT idZona, nome FROM tZona";
            $result = $conn->query($sql);
            if ($result->num_rows == 0) {
                $res = "Nessun dato in tabella";
                }
            else {
                while($row = $result->fetch_assoc()){
                    echo "<option value='".$row['idZona']."'>".$row['nome']."</option>";
                }
            }
            echo "</select><br><br>";
            echo "Password <br> <input type='password' id='txtPassReg' name='txtPassReg'> <br><br>";
            echo "<input type='submit' id='bottone' name='btnRegistra' value='Registrati'> <br><br>";
            echo "</form>";
            echo "</div>";
        }
        $conn->close();
        ?>
    </div>
    </body>

</html>