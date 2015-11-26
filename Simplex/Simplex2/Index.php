<?php
//Melissa Cordeiro Cavalcanti 532533
//Rafael Anselmo Cavalieri 525650
?>

<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=iso-8859-1"/>		
		<title>SIMPLEX</title>
	</head>
	<body>
		<br>
		<form name='form' method='GET' action='S2.php' align='center'>
			<table  border='0' cellspacing='0' cellpadding='0' align='center'>
			<tr><td>Quant. Variáveis</td> <td></td> <td><input type='number' required value='1' min='1'  name='vars'></td>			
			<tr><td>Quant. Restrições</td> <td></td> <td><input type='number' required value='1' min='1' name='rests'></td>			
			</table>
			<br>
			<center><input type='submit' name='enviar' value='Enviar'></center>
		</form>
	</body>
</html>